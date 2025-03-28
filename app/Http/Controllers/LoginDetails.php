<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class LoginDetails extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        try {
            /*
            // Step 1: Authenticate with OFMIS to get the token
            $apiResponse = Http::timeout(15)->post('http://172.17.16.13:8888/api/auth/login', [
                'username' => 'administrator',
                'password' => 'Junnie%123',
                'FileName' => ''
            ]);

            Log::info('OFMIS Login API Response:', ['status' => $apiResponse->status(), 'body' => $apiResponse->body()]);

            if (!$apiResponse->successful()) {
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

            $token = trim($apiData['token']);
            Cache::put('ofmis_token', $token, now()->addMinutes(60));
            Session::put('ofmis_token', $token);

            Log::info('OFMIS Token Retrieved:', ['token' => $token]);

            // Step 2: Fetch user details using the input username dynamically
            $apiUrl = "http://172.17.16.13:8888/OFMIS/user/" . trim($request->username);
            Log::info('OFMIS User API Request:', ['url' => $apiUrl, 'token' => $token]);

            $userDetailsResponse = Http::timeout(15)->withHeaders([
                'Authorization' => "Bearer {$token}",
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ])->get($apiUrl);
            

            Log::info('OFMIS User API Response:', ['status' => $userDetailsResponse->status(), 'body' => $userDetailsResponse->body()]);

            if ($userDetailsResponse->status() == 401) {
                return response()->json([
                    'error' => 'Unauthorized request. The token may be invalid or expired.',
                    'response' => $userDetailsResponse->body()
                ]);
            }

            if (!$userDetailsResponse->successful()) {
                return response()->json([
                    'error' => 'User credentials not found in OFMIS system.',
                    'response' => $userDetailsResponse->body()
                ]);
            }

            $userDetails = $userDetailsResponse->json();
            Log::info('OFMIS User Detail Retrieved:', $userDetails);

            // 🎉 Display Pop-Up with Retrieved User Details 🎉
            Alert::success('User Verified', "Name: {$userDetails['name']}<br>Role: {$userDetails['role']}")->html();
*/
            // Store user details in session (optional)
            Session::put('ofmis_user', $userDetails);

            // Redirect based on role
            return match ($userDetails['role']) {
                'System Admin' => redirect()->route('main.index'),
                'admin' => redirect()->route('admin.dashboard'),
                'staff' => redirect()->route('staff.dashboard'),
                default => back()->with('error', 'Unauthorized access.'),
            };

        } catch (\Exception $e) {
            Log::error('OFMIS API Error:', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Could not connect to OFMIS API. Check network.',
                'exception' => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        Cache::forget('ofmis_token');
        Session::forget('ofmis_token');
        Session::forget('ofmis_user');
        return redirect()->route('login');
    }
}
