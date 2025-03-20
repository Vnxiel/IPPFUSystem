<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class LoginDetails extends Controller
{
    public function authenticate(Request $request)
    {
        // Validate input fields
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Fetch user from local database
        $user = User::where('username', $request->username)->first();

        // If user does not exist
        if (!$user) {
            return back()->with('error', 'User does not exist in the system.');
        }

        // Check if password matches
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid username or password.');
        }

        /**
         * ----------------------
         * OFMIS API Authentication (Commented)
         * ----------------------
         */
        /*
        try {
            \Log::info('Attempting to connect to OFMIS API...');
            
            $apiResponse = Http::timeout(15)->withHeaders([
                'Accept' => 'application/json'
            ])->post('http://172.17.16.13:8888/api/auth/', [
                'username' => $request->username,
                'password' => $request->password
            ]);

            \Log::info('OFMIS API Response:', [
                'status' => $apiResponse->status(),
                'headers' => $apiResponse->headers(),
                'body' => $apiResponse->body()
            ]);

            if ($apiResponse->failed()) {
                $errorMessage = $apiResponse->body() ?: 'Unknown error from OFMIS API.';
                return back()->with('error', 'Authentication failed with OFMIS. API Error: ' . $errorMessage);
            }

            $apiData = json_decode($apiResponse->body(), true);

            if (!isset($apiData['token'])) {
                return back()->with('error', 'Invalid response from OFMIS API: ' . json_encode($apiData));
            }

            // Fetch user data from OFMIS
            $userDetailsResponse = Http::timeout(15)->withHeaders([
                'Authorization' => 'Bearer ' . $apiData['token']
            ])->get('http://172.17.16.13:8888/OFMIS/user');

            if ($userDetailsResponse->failed()) {
                return back()->with('error', 'Failed to retrieve user details from OFMIS.');
            }

            $userDetails = $userDetailsResponse->json();
            
            // OPTIONAL: Update the local database with OFMIS data
            // $user->update(['name' => $userDetails['name'], 'email' => $userDetails['email']]);

        } catch (\Exception $e) {
            \Log::error('OFMIS API Connection Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Could not connect to OFMIS API. Please check your network.');
        }
        */

        // Log in the user from the local database
        Auth::login($user);

        // Redirect user based on role
        return match ($user->role) {
            'System Admin' => redirect()->route('main.index'),
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => back()->with('error', 'Unauthorized access.')
        };
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
