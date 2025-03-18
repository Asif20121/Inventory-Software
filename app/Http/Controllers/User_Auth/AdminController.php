<?php

namespace App\Http\Controllers\User_Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        return view('dashboard.admin.login');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img('math')]);
    }

    public function login_check(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:6|max:30',
            'captcha' => 'required|captcha',
        ], [
            'email.exists' => 'This email not exists',
            'captcha.captcha' => 'The Captcha Is Invalid',

        ]);

        $status = Admin::where('email', $request->email)->first();
        if ($status->status == '1') {
            $creds = $request->only('email', 'password');
            if (Auth::guard('admin')->attempt($creds)) {
                if (session()->get('url.intended')) {

                    return redirect(session()->get('url.intended'))->with('success', 'Login successfully');
                } else {

                    return redirect()->route('admin.dashboard')->with('success', 'Login successfully');
                }
            } else {
                return redirect()->route('admin.login')->with('error', 'Email and Password Does not match');
            }
        } else {
            return redirect()->route('admin.login')->with('error', 'Your Account is not Active');
        }
    }

    public function dashboard()
    {
        return view('dashboard.admin.dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout Successfully');
    }

}
