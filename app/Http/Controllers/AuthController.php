<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Mail\Message;
use Illuminate\Http\Request;
use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $credentials = $request->only('first_name', 'last_name', 'email', 'password');
        
        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:pm_user'
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $password = $request->password;
        $user_type = $request->user_type;
        $roles = "a:1:{i:0;s:13:\"ROLE_EMPLOYER\";}";
        if($user_type == "candidate") {
        	$roles = "a:1:{i:0;s:14:\"ROLE_CANDIDATE\";}";
        }
        
        $user = User::create(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 
        						'username' => $email, 'username_canonical' => $email, 'email_canonical' => $email, 
        						'password' => Hash::make($password), 'enabled' => '1', 'roles' => $roles, 'user_type' => $user_type, 'gdpr_compliance' => '1']);
        $verification_code = str_random(30); //Generate verification code
        DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);
        $subject = "Please verify your email address.";
        Mail::send('email.verify', ['first_name' => $first_name, 'verification_code' => $verification_code],
            function($mail) use ($email, $first_name, $subject){
                $mail->from(getenv('FROM_EMAIL_ADDRESS'), "alvin@previewme.co");
                $mail->to($email, $first_name);
                $mail->subject($subject);
            });
        return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.']);
    }

    /**
     * API Verify User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser($verification_code)
    {
        $check = DB::table('user_verifications')->where('token',$verification_code)->first();
        if(!is_null($check)){
            $user = User::find($check->user_id);
            if($user->is_verified == 1){
                return response()->json([
                    'success'=> true,
                    'message'=> 'Account already verified..'
                ]);
            }
            $user->update(['is_verified' => 1]);
            DB::table('user_verifications')->where('token',$verification_code)->delete();
            return response()->json([
                'success'=> true,
                'message'=> 'You have successfully verified your email address.'
            ]);
        }
        return response()->json(['success'=> false, 'error'=> "Verification code is invalid."]);
    }

    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()], 401);
        }
        
        $credentials['is_verified'] = 1;
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 404);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => $token ]], 200);
    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        
        $this->validate($request, ['token' => 'required']);
        
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }

    /**
     * API Recover Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }
        try {
            Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject('Your Password Reset Link');
            });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }
        return response()->json([
            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
        ]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
    	$token = $request->token;
    	$user = '';

    	$check = DB::table('password_resets')->where('token', $token)->first();
        if(!is_null($check)){
        	$email = $check->email;
    		$user = User::where('email', $email)->first();
        }
        if (!$user) {
            $error_message = "Reset token invalid.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        if(!is_null($user)){
        	DB::table('password_resets')->where('email', $email)->delete();
        	return response()->json([
	            'success' => true, 'data'=> ['message'=> 'Password reset successful.']
	        ]);
        }
    }

    /**
     * API Forgot password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgot(Request $request)
    {
    	$email = $request->email;

    	$check = DB::table('password_resets')->where('email', $email)->first();
        if(!is_null($check)){
            DB::table('password_resets')->where('email',$email)->delete();
        }

        $token = str_random(30); //Generate token
        DB::table('password_resets')->insert(['email'=>$email,'token'=>$token]);
        $subject = "Password reset";
        Mail::send('email.reset', ['token' => $token],
            function($mail) use ($email, $subject){
                $mail->from(getenv('FROM_EMAIL_ADDRESS'), "alvin@previewme.co");
                $mail->to($email);
                $mail->subject($subject);
            });
        return response()->json(['success'=> true, 'message'=> 'We sent a link to your email for the password reset.']);
    }

    /**
     * Get Authenticated User Data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['success'=> false, 'message' => 'User not found'], 404);
            }
        } catch (\TokenExpiredException $e) {
            return response()->json(['success' => false, 'message' => 'token_expired'], $e->getStatusCode());
        } catch (\TokenInvalidException $e) {
            return response()->json(['success' => false, 'message' => 'token_invalid'], $e->getStatusCode());
        } catch (\JWTException $e) {
            return response()->json(['success' => false, 'message' => 'token_absent'], $e->getStatusCode());
        }

        $user_data = User::where('id', $user->id)
                        ->with('employer')
                        ->with('employer.company')
                        ->get();

        return response()->json(['success' => true, 'data'=> $user_data], 200);
    }
}
