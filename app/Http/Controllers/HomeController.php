<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    //email verification link sent
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/home');
    }
    //email verification notice about verification link
    public function verify_notice() 
    {
        $auth = Auth::user()->email_verified_at;
        if($auth != null){
            return redirect('/home');
        }
        return view('auth.verify');
    }
    //email verification link->resend link
    public function verify_resend() 
    {
        return view('auth.verify');
    }
    //change password view
    public function change_password_view()
    {
        return view('auth.change_password');
    }
    //update password
    public function update_password(Request $request)
    {
        
        $user = Auth::user();
        $request->validate([
            'current_password'=>'required',
            'password'=>'required|min:8|string|confirmed',
            'password_confirmation'=>'required',
        ] );
        if(Hash::check($request->current_password, $user->password))
        {
            // $user->password = Hash::make($request->new_password);
            // $user->save();
            $data = array(
                'password'=>Hash::make($request->password),
            );
            DB::table('users')->where('id',$user->id)->update($data);
            Auth::logout();
            return redirect('/login')->with('success','Password Updated Successfully!');
        }else{
            return redirect()->back()->with('error','Current Password Not Matched!');
        }
    }
}
