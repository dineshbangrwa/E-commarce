<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {

        return view('login');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // $data =$request->only('email','password');

        $data = $request->only('email', 'password');
        $data['is_admin'] = 1;

        if (Auth::attempt($data)) {
            return redirect()->route('dashboard')->with('message', 'Well-Come to Login Successfully ');
        } else {
            return redirect()->route('admin.login')->with('message', 'Login is faild');
        }
    }

    public function logout()
    {
        $data = Auth::logout();

        return redirect()->route('admin.login')->with('message', 'logout is succesfully');
    }

    public function adminregister(Request $request)
    {
        // dd($request->all());

        $insert = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'password_confirmation' => $request->password,
            'gender' => 1,
            'is_admin' => 0,
        ];
        $user = User::create($insert);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $user->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('login')->with('message', 'register is successfully');
    }
}
