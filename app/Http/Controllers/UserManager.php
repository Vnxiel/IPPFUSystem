<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\ActLogs;
use App\Http\Controllers\ActivityLogs;

class UserManager extends Controller
{
    /* If there is no user currently registered, the first user will redirected to the Registration 
    Page exclusive for first user, else, it will stay in the login page. */
    public function index(){
        $userExists = User::count() > 0;
        if (!$userExists) {
            return redirect()->route('systemAdmin.register');
        }
    
        return view('index');  
    }

    public function goToRegister(){
        $userExists = User::count() > 0;
        if ($userExists) {
            return redirect()->route('index');
        }
        return view('systemAdmin.register');  
    }

    public function registerSystemAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ofmis_id' => 'required', 
            'fullname' => 'required|min:3',
            'position' => 'required',
            'username' => 'required|unique:users_tbl,username',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(0); 
        } 
    
            // Check if this is the first user
            $isFirstUser = User::count() === 0;

        $user = User::create([
            'ofmis_id' => $request->ofmis_id,
            'fullname' => $request->fullname,
            'position' => $request->position,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $isFirstUser ? 'System Admin' : 'Staff', 
            'time_frame' => 'Permanent',
        ]);

        return response()->json([
            'status' => 1,
            'message' => $isFirstUser ? 'System Admin' : 'Staff',
        ]);
    }

    public function changeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ofmis_id' => 'required|exists:users_tbl,ofmis_id',
            'userRole' => 'required|string',
            'time_frame' => 'required|string',
            'timeLimit' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(0); 
        }

        $user = User::find($request->id);
        $user->role = $request->userRole;
        $user->time_frame = $request->time_frame;
        if ($request->has('timeLimit')) {
            $user->timeLimit = $request->timeLimit;
        }
        $user->save();

        $activityLogData = [
            'performedBy' => auth()->user()->id,
            'role' => $user->role,
            'action' => "Changed role to {$user->role}",
        ];
        (new ActivityLogs())->store(new Request($activityLogData));

        return response()->json(1); 
    }

    public function userLogin(Request $request){
        $validator = Validator::make($request->all(), 
        [
            'username' => 'required|string|max:20',
            'password' => 'required|min:6|max:20',
        ]);
    
        if ($validator->fails()) {
            return response()->json([ 
                'message' => $validator->getMessageBag()
            ]);
        } 
    
        $username = $request->input('username');
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        } 
    
        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid username or password'], 401);
        }
    
        // Ensure pointToSystemAccount succeeds before logging in
        $pointToSystemAccountResponse = $this->pointToSystemAccount($request);
        $pointToSystemAccountData = json_decode($pointToSystemAccountResponse->getContent(), true);
    
        if (isset($pointToSystemAccountData['error'])) {
            return response()->json($pointToSystemAccountData, 401);
        }
    
        // Proceed to log in if pointToSystemAccount is successful
        if ($user->role === 'System Admin' || $user->role === 'Admin' || $user->role === 'Staff') {
            $request->session()->put('loggedIn', [
                'ofmis_id' => $user->ofmis_id,
                'performedBy' => $user->username,
                'role' => $user->role,
                'action' => "Logged in into the system.",
            ]);
    
            if (session()->has('loggedIn')) {
                $ofmis_id = session()->get('loggedIn')['ofmis_id'];
                $performedBy = session()->get('loggedIn')['performedBy'];
                $role = session()->get('loggedIn')['role'];
                $action = session()->get('loggedIn')['action'];
                (new ActivityLogs)->userAction($ofmis_id, $performedBy, $role, $action);
            } else {
                return response()->json(['error' => 'Session not found'], 401);
            }
    
            // Return values based on user role
            return $user->role === 'System Admin' ? 1 : ($user->role === 'Admin' ? 2 : 0);
        }
    
        return response()->json(['error' => 'Unauthorized access'], 401);
    }
    
    public function validateUser(Request $request) {}
    public function pointToSystemAccount(Request $request)
    {
        \Log::info("Received request for pointToSystemAccount", $request->all());
    
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:20', // Ensure username is provided
        ]);
    
        if ($validator->fails()) {
            \Log::error("Validation failed", $validator->getMessageBag()->toArray());
            return response()->json(['message' => $validator->getMessageBag()], 400);
        }
    
        // Find user in local database
        $user = User::where('username', $request->input('username'))->first();
    
        if (!$user) {
            \Log::error("User not found in local database", ['username' => $request->input('username')]);
            return response()->json(['error' => 'User not found'], 404);
        }
    
        // Authenticate with OFMIS API
        $ofmisAuthResponse = $this->authenticateWithOFMIS();
        \Log::info("OFMIS Auth Response", $ofmisAuthResponse);
    
        if (!$ofmisAuthResponse || !isset($ofmisAuthResponse['token'])) {
            \Log::error("OFMIS Authentication failed", $ofmisAuthResponse);
            return response()->json(['error' => 'OFMIS Authentication Failed'], 401);
        }
    
        $token = $ofmisAuthResponse['token'];
    
        // Retrieve user details from OFMIS API
        $ofmisUserData = $this->getOFMISUserData($token, $user->username);
        \Log::info("OFMIS User Data Response", $ofmisUserData);
    
        if (!is_array($ofmisUserData) || !isset($ofmisUserData['fullname'])) {
            \Log::error("Failed to retrieve OFMIS user data", [
                'username' => $user->username,
                'response' => $ofmisUserData
            ]);

            return response()->json([
                'error' => 'Failed to retrieve OFMIS user data',
                'details' => $ofmisUserData
            ], 401);
        }
    
        // Compare user details
        if (
            $user->fullname === $ofmisUserData['fullname'] &&
            $user->position === $ofmisUserData['position']
        ) {
            $request->session()->put('loggedIn', [
                'ofmis_id' => $user->ofmis_id,
                'performedBy' => $user->username,
                'role' => $user->role,
                'action' => "Logged in into the system.",
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'User logged in']);
        } else {
            \Log::error("User credentials do not match OFMIS records", [
                'local' => ['fullname' => $user->fullname, 'position' => $user->position],
                'OFMIS' => ['fullname' => $ofmisUserData['fullname'], 'position' => $ofmisUserData['position']]
            ]);
    
            return response()->json(['error' => 'User credentials do not match OFMIS records'], 401);
        }
    }
    

    /**
     *  Function: authenticateWithOFMIS()
     *  Magpapadala ng username at password sa OFMIS Authentication API upang makakuha ng token.
     */
    private function authenticateWithOFMIS()
{
    $authUrl = "http://172.17.16.13:8888/api/auth/login";

    try {
        $response = Http::post($authUrl, [
            'username' => 'administrator',
            'password' => 'Junnie%123',
            'FileName' => ''
        ]);

        \Log::info("OFMIS Authentication API Response", $response->json());

        return $response->json();
    } catch (\Exception $e) {
        \Log::error("OFMIS Authentication API Error", ['message' => $e->getMessage()]);
        return null;
    }
}

    /**
     *  Function: getOFMISUserData()
     *  Gagamitin ang authentication token para makuha ang user details mula sa OFMIS API.
     */
    private function getOFMISUserData($token, $username)
    {
        // OFMIS API endpoint 
        $userInfoUrl = "http://172.17.16.13:8888/OFMIS/user/{$username}";
    
        try {
            \Log::info("🔹 Requesting OFMIS user data", [
                'url' => $userInfoUrl,
                'username' => $username,
                'token' => $token
            ]);
    
            // Send GET request with Bearer Token
            $response = Http::withHeaders([
                'Authorization' => "Bearer $token",
            ])->get($userInfoUrl);
    
            $responseData = $response->json();
            
            \Log::info("✅ OFMIS User Info API Response", [
                'status' => $response->status(),
                'data' => $responseData
            ]);
    
            if ($response->failed()) {
                \Log::error("❌ OFMIS User Data Retrieval Failed", [
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return null;
            }
    
            return $responseData;
        } catch (\Exception $e) {
            \Log::error("❌ OFMIS User Info API Error", [
                'message' => $e->getMessage(),
                'username' => $username
            ]);
            return null;
        }
    }
    



    public function getUserAction(Request $request) {}

    public function projects() {
        return view('main.projects');  // Returns the 'projects.blade.php' view
    }

    public function overview() {
        return view('main.overview');  // Returns the 'overview.blade.php' view
    }

    public function trash() {
        return view('main.trash');  // Returns the 'trash.blade.php' view
    }

    public function activityLogs() {
        return view('main.activityLogs');  // Returns the 'activityLogs.blade.php' view
    }

    //When logging out it will check if the session variable exists then
    // it will retrieve the user's information, log the the activity before clearing the session data. 
    public function logout(Request $request) {
        $user = auth()->user(); 

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Log the logout action
        (new ActivityLogs)->userAction(
            $user->ofmis_id, 
            $user->username, 
            $user->role, 
            "Logged out from the system."
        );

        // Perform logout
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('/');
    }
}
