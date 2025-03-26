<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class LoginDetails extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Fetch user from local database
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            Alert::error('Error', 'Invalid username or password.');
            return back();
        }

        try {
            /**
             * ----------------------
             * Authenticate with OFMIS API (Commented Out)
             * ----------------------
             */
        
            $apiUrl = rtrim(env('OFMIS_API_URL'), '/') . '/api/auth/login';
            \Log::info('Calling OFMIS Login API:', ['url' => $apiUrl]);

            $apiResponse = Http::timeout(15)->post($apiUrl, [
                'username' => $request->username,
                'password' => $request->password,
                'FileName' => ''
            ]);

            \Log::info('OFMIS Login API Response:', ['body' => $apiResponse->body()]);

            if (!$apiResponse->successful() || empty($apiResponse->body())) {
                \Log::error("OFMIS Login API failed: " . $apiResponse->body());
                return back()->with('error', 'Authentication failed with OFMIS.');
            }

            $apiData = json_decode($apiResponse->body(), true);

            if (!isset($apiData['token']) || empty($apiData['token'])) {
                return back()->with('error', 'Invalid response from OFMIS API.');
            }

            $token = $apiData['token'];
            Cache::put('ofmis_token', $token, now()->addMinutes(60));
            Session::put('ofmis_token', $token);
        

            /**
             * ----------------------
             * Fetch User Role from OFMIS (Commented Out)
             * ----------------------
             */
            
            $userApiUrl = rtrim(env('OFMIS_API_URL'), '/') . '/OFMIS/user/';
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ];

            \Log::info('Fetching user details from OFMIS:', ['url' => $userApiUrl]);

            $userDetailsResponse = Http::withHeaders($headers)
                ->timeout(15)
                ->get($userApiUrl);

            \Log::info('OFMIS User API Response:', ['body' => $userDetailsResponse->body()]);

            if (!$userDetailsResponse->successful()) {
                \Log::error("OFMIS User API failed: " . $userDetailsResponse->body());
                return back()->with('error', 'User details not found in OFMIS.');
            }

            $userDetails = json_decode($userDetailsResponse->body(), true);

            if (!isset($userDetails['role'])) {
                return back()->with('error', 'User role missing in OFMIS response.');
            }

            $userRole = $userDetails['role']; // Store the role
                

            // Simulating a user role since API is commented out
            $userRole = $user->role; // Assuming local database role
            Session::put('user_role', $userRole);

            \Log::info('User role retrieved:', ['role' => $userRole]);

        } catch (\Exception $e) {
            \Log::error('OFMIS API Connection Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Could not connect to OFMIS API. Check network.');
        }

        // Log in user in Laravel
        Auth::login($user);

        // Step 3: Redirect User Based on Role
        switch ($userRole) {
            case 'System Admin':
                return redirect()->route('main.index');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'staff':
                return redirect()->route('staff.dashboard');
            default:
                return back()->with('error', 'Unauthorized access.');
        }
    }

    public function logout()
    {
        Cache::forget('ofmis_token');
        Session::forget('ofmis_token');
        Session::forget('user_role');

        Auth::logout();
        return redirect()->route('login');
    }
}
