<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\ActivityHistory;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Str;

class AuthController extends Controller
{
    public function login(Request $request) {
        try {
            $this->validate($request, [
                'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
                'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/'
            ]);

            $email = $request->email;
            $password = $request->password;

            $user = User::where('email', $email)->first();

            if($user) {
                if($user->email_verification_token != null && $user->email_verified_status == 0){
                    return redirect()->route('login')->with(['status' => 'error', 'message' => 'your email address not verified, kindly check email and verify your email account']);
                }elseif($user->status == 0){
                    return redirect()->route('login')->with(['status' => 'error', 'message' => 'your account has been deactivated, kindly contact admin']);
                }elseif(Auth::guard('web')->attempt(['email' => $email, 'password' => $password, 'status' => 1])){
                    $user = Auth::user();

                    $agent = new Agent();
                    $device = $agent->device();
                    $platform = $agent->platform();
                    $browser = $agent->browser();
                    $visitor = request()->ip();
                    $today = Carbon::today()->toDateString();
                    
                    $activity_history = ActivityHistory::whereDate('created_at', '!=', $today)->first();
                    if(!$activity_history) {
                        $activity_history = new ActivityHistory();
                    }
                    $activity_history->user_id = $user->id;
                    $activity_history->action = 'login';
                    $activity_history->ip_address = $visitor;
                    $activity_history->browser = $browser;
                    $activity_history->device = $device;
                    $activity_history->platform = $platform;
                    $activity_history->save();
                    
                    return redirect()->route('dashboard')->with(['status' => 'success', 'message' => 'welcome back '.$user->first_name.' '.$user->last_name]);
                }else{
                    return redirect()->back()->with(['status' => 'error', 'message' => 'incorrect password']);
                }
            }else{
                return redirect()->back()->with(['status' => 'error', 'message' => 'email address not found']);
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again.']);
        }

    }

    public function register(Request $request) {

        $messages = [
            'dob.required' => 'The date of birth is required.',
            'dob.date' => 'The date of birth must be a valid date.',
            'dob.before_or_equal' => 'The minimum age should be 18 years old.',
        ];

        $this->validate($request, [
            'dob' => 'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
            'first_name' => 'required|min:3',
            'last_name' => 'required',
            'password' => 'required|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email'
        ], $messages);

        try {
            
            $dob = $request->dob;
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $password = $request->password;
            $email = $request->email;

            $user = new User();
            $user->dob = $dob;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->password = $password;
            $user->email_verification_token = Str::random(32);
            $user->email = $email;
            $user->save();

            Mail::send('mails.email_verification',
                ['user' => $user, 'token' => $user->email_verification_token], function ($m) use ($user) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->to($user->email, $user->first_name. ' '. $user->last_name);
                    $m->subject("Confirm account email");
                }
            );

            return redirect()->route('login')->with(['status' => 'success', 'message' => 'your account has been register successfully, please verify your account before login']);

        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again.']);
        }
    }

    public function emailVerify($token) {

        try {
            $verify_token = $token;
            $user = User::where('email_verification_token', $verify_token)->firstOrFail();
    
            $user->email_verification_token = null;
            $user->email_verified_status = 1;
            $user->save();
    
            return redirect()->route('login')->with(['status' => 'success', 'message' => 'Your account has been verified successfully']);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('login')->with(['status' => 'error', 'message' => 'Your account has been verified already']);
        } catch (Exception $e) {
            return redirect()->route('login')->with(['status' => 'error', 'message' => 'An error occurred while verifying your account. Please try again.']);
        }
    }

    public function logout()
    {
        try {
            $user = Auth::user();

            $agent = new Agent();
            $device = $agent->device();
            $platform = $agent->platform();
            $browser = $agent->browser();
            $visitor = request()->ip();
            
            $activity_history = new ActivityHistory();
            $activity_history->user_id = $user->id;
            $activity_history->action = 'logout';
            $activity_history->ip_address = $visitor;
            $activity_history->browser = $browser;
            $activity_history->device = $device;
            $activity_history->platform = $platform;
            $activity_history->save();

            Auth::guard('web')->logout();


            return redirect()->route('login')->with(['status' => 'success', 'message' => 'account has been successfully logged out']);
        }catch (Exception $e) {
            return redirect()->route('login')->with(['status' => 'error', 'message' => 'An error occurred while verifying your account. Please try again.']);
        }
    }
}
