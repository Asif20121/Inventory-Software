<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForgotController extends Controller
{
    public function forget_password()
    {
        return view('dashboard.admin.forget_password');
    }

    public function forget_password_send(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $resetToken = \Str::random(64);
        $userEmail = $request->email;

        $existingToken = DB::table('password_resets')
            ->where('email', $userEmail)
            ->where('created_at', '>', Carbon::now()->subHour(1))
            ->first();
            try {
        if ($existingToken) {
            return back()->with('success', 'Already send password reset link!');
        } else {
            DB::table('password_resets')
                ->where('email', $userEmail)->delete();

            DB::table('password_resets')->insert([
                'email' => $userEmail,
                'token' => $resetToken,
                'created_at' => Carbon::now(),
            ]);

            $action_link = route('admin.forget_password_link', ['token' => $resetToken, 'email' => $userEmail]);
            $body = "We are received a request to reset the password for <b>Your app Name </b> account associated with " . $userEmail . ". You can reset your password by clicking the link below";

            \Mail::send('email-forgot', ['action_link' => $action_link, 'body' => $body], function ($message) use ($userEmail) {
                $message->to($userEmail)
                    ->subject('Reset Password');
            });

            return back()->with('success', 'We have e-mailed your password reset link!');
        }
    } catch (\Exception $e) {
        return back()->with('error', 'Email Configuration Problem');
        }
    }

    public function forget_password_link(Request $request, $token = null)
    {
        return view('reset')->with(['token'=>$token,'email'=>$request->email]);
    }

    public function forget_password_change(Request $request){
        $request->validate([
            'email'=>'required|email|exists:admins,email',
            'password'=>['required','confirmed','min:6','max:50','regex:/[a-z]/','regex:/[A-Z]/'],
            'password_confirmation'=>'required',
        ], [
            'password.regex' => "Password must be one capital letter and one small letter"
        ]);

        $check_token = DB::table('password_resets')->where(['email'=>$request->email,'token'=>$request->token])->first();

      if(!$check_token){
        return back()->with('error', 'Invalid token');
    }else{

        Admin::where('email', $request->email)->update([
            'password'=>\Hash::make($request->password)
        ]);

        DB::table('password_resets')->where([ 'email'=>$request->email])->delete();

        return redirect()->route('admin.login')->with('success', 'Your password has been changed! You can login with new password');
    }
    }
}
