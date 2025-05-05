<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\ActivityLog;
use App\Http\Controllers\ActivityLogs;
use App\Models\Contractor;
use App\Models\Project;

class UserManager extends Controller
{
    /* If there is no user currently registered, the first user will redirected to the Registration 
    Page exclusive for first user, else, it will stay in the login page. */
    public function index(){
        $userExists = User::count() > 0;
        if (!$userExists) {
            return redirect()->route('FirstUserRegistration.register');
        }
    
        return view('index');  
    }

    public function goToRegister(){
        $userExists = User::count() > 0;
        if ($userExists) {
            return redirect()->route('index');
        }
        return view('FirstUserRegistration.register');  
    }

    public function registerSystemAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ofmis_id' => 'required', 
            'fullname' => 'required|min:3',
            'position' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()->all()
            ]); 
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
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username
                ]
            ]);
    }
    public function changeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ofmis_id' => 'required|exists:users,ofmis_id',
            'userRole' => 'required|string',
            'time_frame' => 'required|string',
            'time_limit' => 'nullable|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json(0); 
        }
    
        $user = User::find($request->id);
    
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found.'], 404);
        }
    
        // Apply role changes
        if ($request->userRole === 'Admin' && $request->time_frame === 'Temporary') {
            $user->temp_role = $user->role;
            $user->role = 'Admin';
            $user->time_limit = $request->time_limit;
        } else {
            $user->role = $request->userRole;
            $user->temp_role = null;
            $user->time_limit = null;
        }
    
        $user->time_frame = $request->time_frame;
        $user->save();
    
        // ✅ Activity logging
        if (session()->has('loggedIn')) {
            $sessionData = session()->get('loggedIn');
            $action = "Changed role of user '{$user->username}' to '{$user->role}' ({$request->time_frame})";
    
            $request->session()->put('ChangedUserRole', [
                'user_id' => $sessionData['user_id'],
                'ofmis_id' => $sessionData['ofmis_id'],
                'performedBy' => $sessionData['performedBy'],
                'role' => $sessionData['role'],
                'action' => $action,
            ]);
    
            \Log::info("User action logged: " . json_encode($request->session()->get('ChangedUserRole')));
    
            (new ActivityLogs)->userAction(
                $sessionData['user_id'],
                $sessionData['ofmis_id'],
                $sessionData['performedBy'],
                $sessionData['role'],
                $action
            );
        }
    
        return response()->json(1);
    }

public function userLogin(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:20',
        'password' => 'required|min:6|max:20',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => $validator->getMessageBag()
        ], 422);
    }

    $username = $request->input('username');
    $user = User::where('username', $username)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    Auth::login($user);

    if (in_array($user->role, ['System Admin', 'Admin', 'Staff'])) {
        $request->session()->put('loggedIn', [
            'user_id' => $user->id,
            'ofmis_id' => $user->ofmis_id,
            'performedBy' => $user->username,
            'role' => $user->role,
            'action' => "Logged in into the system.",
            'time_limit' => $user->time_limit, // Save user's expiration time
            'time_frame' => $user->time_frame,
        ]);

        if (session()->has('loggedIn')) {
            $log = session()->get('loggedIn');
            (new ActivityLogs)->userAction(
                $log['user_id'],
                $log['ofmis_id'],
                $log['performedBy'],
                $log['role'],
                $log['action']
            );
        }

        $redirect = match ($user->role) {
            'System Admin' => route('systemAdmin.index'),
            'Admin' => route('admin.index'),
            'Staff' => route('staff.index'),
            default => null,
        };

        return response()->json([
            'redirect' => $redirect,
            'role' => $user->role,
        ]);
    }

    return response()->json(['error' => 'Unauthorized role'], 403);
}

    
    public function validateUser(Request $request) {}

    public function pointToSystemAccount(Request $request)
    {
        //  Step 1: I-validate ang request para siguraduhin na may "username" na ipinasok
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:20', // Dapat may username
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()], 400); 
            // Kung hindi valid, ibalik ang error message (HTTP 400 - Bad Request)
        }

        //  Step 2: Hanapin ang user sa **local database**
        $user = User::where('username', $request->input('username'))->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
            // Kung walang nakita sa database, ibalik ang error (HTTP 404 - Not Found)
        }

        //  Step 3: Gamitin ang **OFMIS API Authentication** para makakuha ng token
        $ofmisAuthResponse = $this->authenticateWithOFMIS();

        if (!$ofmisAuthResponse || !isset($ofmisAuthResponse['token'])) {
            return response()->json(['error' => 'OFMIS Authentication Failed'], 401);
            // Kung hindi nagtagumpay sa authentication, ibalik ang error (HTTP 401 - Unauthorized)
        }

        $token = $ofmisAuthResponse['token']; // Kunin ang authentication token mula sa response

        //  Step 4: Gamitin ang token para kunin ang user details mula sa OFMIS API
        $ofmisUserData = $this->getOFMISUserData($token, $user->username);

        if (!$ofmisUserData) {
            return response()->json(['error' => 'Failed to retrieve OFMIS user data'], 401);
            // Kung walang nakuha na user data, ibalik ang error (HTTP 401 - Unauthorized)
        }

        //  Step 5: I-compare ang user data sa local database at sa OFMIS API
        if (
            $user->fullname === $ofmisUserData['fullname'] && // I-check kung parehas ang pangalan
            $user->position === $ofmisUserData['position']   // I-check kung parehas ang posisyon
        ) {
            //  Step 6: Kung tugma, i-log in ang user at i-save ang session
            $request->session()->put('loggedIn', [
                'ofmis_id' => $user->ofmis_id,
                'performedBy' => $user->username,
                'role' => $user->role,
                'action' => "Logged in into the system.",
            ]);

            return response()->json(['status' => 'success', 'message' => 'User logged in']);
            // Ibalik ang success response
        } else {
            return response()->json(['error' => 'User credentials do not match OFMIS records'], 401);
            // Kung hindi tugma ang credentials, ibalik ang error (HTTP 401 - Unauthorized)
        }
    }

    /**
     *  Function: authenticateWithOFMIS()
     *  Magpapadala ng username at password sa OFMIS Authentication API upang makakuha ng token.
     */
    private function authenticateWithOFMIS($username, $password)
    {
        $authUrl = "http://172.17.16.13:8888/api/auth/login"; // OFMIS auth URL

        $response = Http::post($authUrl, [
            'username' => 'administrator',
            'password' => 'Junnie%123',
            'FileName' => ''
        ]);

        return $response->json(); // Ibalik ang response mula sa API (kasama ang token kung successful)
    }

    /**
     *  Function: getOFMISUserData()
     *  Gagamitin ang authentication token para makuha ang user details mula sa OFMIS API.
     */
    private function getOFMISUserData($token, $username)
    {
        $userInfoUrl = "http://172.17.16.13:8888/OFMIS/user/{$username}"; //  Palitan ito ng totoong OFMIS endpoint

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token", // Ilagay ang token sa request header
        ])->get($userInfoUrl);

        return $response->json(); // Ibalik ang response mula sa API (kasama ang user details kung successful)
    }
    
    

    public function trash() {
        return view('systemAdmin.trash');  // Returns the 'trash.blade.php' view
    }


  
    public function projects()
    {
        $contractors = Contractor::orderBy('name')->get();
        $staticLocations = [
            'Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi',
            'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano',
            'Villaverde', 'Ambaguio', 'Santa Fe'
        ];
    
        $dbLocations = Project::select('projectLoc')
            ->whereNotNull('projectLoc')
            ->pluck('projectLoc')
            ->toArray();
    
        // Merge and remove duplicates
        $allLocations = collect(array_merge($staticLocations, $dbLocations))
            ->unique()
            ->sort()
            ->values();

        $sourceOfFunds = Project::select('sourceOfFunds')
        ->distinct()
        ->whereNotNull('sourceOfFunds')
        ->orderBy('sourceOfFunds')
        ->get();
        $projectYear = Project::select('projectYear')
        ->distinct()
        ->whereNotNull('projectYear')
        ->orderBy('projectYear')
        ->get();
        $projectEA = Project::select('ea')
        ->distinct()
        ->whereNotNull('ea')
        ->orderBy('ea')
        ->get();


        // default to system admin
        return view('systemAdmin.projects', compact('contractors', 'allLocations', 'sourceOfFunds', 'projectEA', 'projectYear'));
    }
    
    

    public function overview()
    {
        // 1. Load your data
        $contractors = Contractor::orderBy('name')->get();
    
        // 3. Otherwise, show the system‑admin overview
        return view('systemAdmin.overview', compact('contractors'));
    }
    



    public function activityLogs() {
        return view('systemAdmin.activityLogs');  // Returns the 'activityLogs.blade.php' view
    }

    //When logging out it will check if the session variable exists then
    // it will retrieve the user's information, log the the activity before clearing the session data. 
    public function logout(Request $request)
    {
        $user = auth()->user();
    
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        try {
            // Log activity using current authenticated user (not session)
            (new ActivityLogs)->userAction(
                $user->id,
                $user->ofmis_id,
                $user->username,
                $user->role,
                'Logged out from the system.'
            );
        } catch (\Exception $e) {
            Log::error('Logout activity log failed: ' . $e->getMessage());
        }
    
        auth()->logout(); // End the user's auth session
        $request->session()->invalidate(); // Kill session
        $request->session()->regenerateToken(); // For security
    
        return redirect()->route('/');
    }
    
        }
