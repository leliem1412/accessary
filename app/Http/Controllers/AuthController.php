<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function show()
    {
        if(Auth::check()) {
            return view('show');
        }
        return view('auth/login');
    }

    public function showRegister()
    {
        if(Auth::check()) {
            return view('show');
        }
        return view('auth/register');
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required",
        ]);

        if ($validated->failed()) {
            return response($validated);
        }

        $userLogin = Auth::attempt($request->all(), true);

        if (!$userLogin || auth()->user()->active == 0) {
            auth()->user()->active == 0 && Auth::logout();
            Alert::warning('Đăng nhập thất bại!', 'Tài khoản hoặc mật khẩu không đúng');
            return response($userLogin);
        }

        Alert::success('Đăng nhập thành công!');
        return response($userLogin);
    }

    public function register(Request $request)
    {
       try {
        $validated = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required",
            "password" => "required",
            "password_confirmation" => "required",
        ]);
        if ($validated->failed()) {
            return response($validated);
        }
        $user = User::where('email', $request->email)->get();
        if ($user) {
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        Alert::success('Đăng ký thành công!');
        return response($user);
       } catch (\Throwable $th) {
        //throw $th;
       }
    }

    public function logout() {
        Auth::logout();
        return response(true);
    }
}
