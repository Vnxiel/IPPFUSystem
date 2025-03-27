<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            Alert::error('Error', 'Invalid username or password.');
            return back();
        }

        try {
            // Authenticate with OFMIS API to get the token
            $apiResponse = Http::timeout(15)->post('http://172.17.16.13:8888/api/auth/login', [
                'username' => 'administrator', 
                'password' => 'Junnie%123',
                'FileName' => ''
            ]);

            // Log API response
            \Log::info('OFMIS Login API Response:', ['body' => $apiResponse->body()]);

            if (!$apiResponse->successful()) {
                \Log::error("OFMIS Login API failed: " . $apiResponse->body());
                return response()->json([
                    'error' => 'Authentication failed with OFMIS.',
                    'response' => $apiResponse->body()
                ]);
            }

            $apiData = $apiResponse->json();
            if (!isset($apiData['token']) || empty($apiData['token'])) {
                return response()->json([
                    'error' => 'Invalid response from OFMIS API (No token)',
                    'response' => $apiData
                ]);
            }

            $token = $apiData['token'];
            Cache::put('ofmis_token', $token, now()->addMinutes(60));
            Session::put('ofmis_token', $token);

            return response()->json([
                'message' => 'Login API working correctly',
                'token' => $token
            ]);

        } catch (\Exception $e) {
            \Log::error('OFMIS Login API Error:', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Could not connect to OFMIS API. Check network.',
                'exception' => $e->getMessage()
            ]);
        }
    }

    public function getUserDetails(Request $request)
    {
        try {
            // Retrieve token from session
            $token = Session::get('ofmis_token');
            if (!$token) {
                return response()->json([
                    'error' => 'OFMIS token missing. Please login first.'
                ]);
            }
    
            // Log API request details
            \Log::info('Calling OFMIS User API with token:', ['Authorization' => 'Bearer ' . $token]);

            // Fetch user credentials from OFMIS (Using GET instead of POST)
            $userDetailsResponse = Http::timeout(15)->withHeaders([
                'Authorization' => 'Bearer ' . trim($token),
                'Accept' => 'application/json'
            ])->get('http://172.17.16.13:8888/OFMIS/user/');

            // Log raw response
            \Log::info('OFMIS User API Raw Response:', ['body' => $userDetailsResponse->body()]);

            if (!$userDetailsResponse->successful()) {
                \Log::error("OFMIS User API failed:", [
                    'status' => $userDetailsResponse->status(),
                    'response' => $userDetailsResponse->body()
                ]);
                return response()->json([
                    'error' => 'User credentials not found in OFMIS system.',
                    'status' => $userDetailsResponse->status(),
                    'response' => $userDetailsResponse->body()
                ]);
            }

            // Decode and log user details
            $userDetails = $userDetailsResponse->json();
            \Log::info('OFMIS User Details Retrieved:', $userDetails);

            // Log user into Laravel session
            Auth::login($user);
            $userRole = $user->role; // Ensure your User model has a 'role' field

            // Redirect based on user role
            return match ($userRole) {
                'System Admin' => redirect()->route('main.index'),
                'admin' => redirect()->route('admin.dashboard'),
                'staff' => redirect()->route('staff.dashboard'),
                default => back()->with('error', 'Unauthorized access.'),
            };

        } catch (\Exception $e) {
            \Log::error('OFMIS User API Error:', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Could not connect to User API.',
                'exception' => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        Cache::forget('ofmis_token');
        Session::forget('ofmis_token');
        Auth::logout();
        return redirect()->route('login');
    }
}
