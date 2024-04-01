<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\UserLogin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\SendMail;
use function Laravel\Prompts\alert;

class UserAuthController extends Controller
{

    public function userlist()
    {
        return view('users');
    }

    public function user()
    {
        Auth::guard('admin')->logout();
        Auth::guard('user')->logout();
        return view('userlogin');
    }

    public function loginuser(UserLoginRequest $request)
    {
        Auth::guard('admin')->logout();
        $user = UserLogin::where('email', $request->email)->first();
//        echo '<pre>'; print_r($user);
//        $rr = $request->paassword;
//        dd($rr);
        if ($user === null) {
            return redirect()->route('user');
        } else {
//            dd('hello pass');
            if (Hash::check($request->password, $user->password)) {
                if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    return redirect()->route('users.list');
                } else {
                    return redirect()->route('user');
                }
            }
        }

    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            $user = UserLogin::where('google_id', $google_user->id)->first();

            if (!$user) {
                $new_user = new UserLogin();
                $new_user->firstname = $google_user->getName();
                $new_user->lastname = $google_user->getName();
                $new_user->email = $google_user->email;
                $new_user->google_id = $google_user->getId();
                $new_user->password = Hash::make($google_user->password);
                $new_user->save();
                $mailData = [
                    'title' => 'Mohil Soni',
                    'body' => 'This mail is for testing purpose only !!',
                ];
                Mail::to($google_user->getEmail())->send(new SendMail($mailData));
                return redirect()->route('user');

            }else{
                Auth::guard('user')->login($user);
                return redirect()->route('users.list');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function register()
    {
        return view('register');
    }

    public function store(UserRegisterRequest $request)
    {
        $user = new UserLogin();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $mailData = [
            'title' => 'Mohil Soni',
            'body' => 'This mail is for testing purpose only !!',
        ];

        Mail::to($request->email)->send(new SendMail($mailData));
        return redirect()->route('user');
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('user');
    }
}
