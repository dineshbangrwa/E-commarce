<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomLoginController extends Controller
{
    public function index(Request $request)
    {

        // dd($request->all());
        return view('custom_login');
    }

    public function store(Request $request)
    {

        $validate = [
            'email' => 'string',
            'max:255',
            'password' => 'string',
            'max:255',

        ];
        $data = $request->only('email', 'password');
        $langCode = session('language_code', app()->getLocale());

        if (Auth::attempt($data)) {

            return redirect()->route('lang.index', ['lang' => $langCode])->with('message', 'Login is Successfully');
        } else {

            return redirect()->route('login', ['lang' => $langCode])->with('error', 'login is faild');
        }
    }

    public function register()
    {
        return view('register');
    }

    public function registerStore(Request $request)
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
        // dd($request->all());
        $langCode = session('language_code', app()->getLocale());

        return redirect()->route('lang.index', ['lang' => $langCode])->with('message', 'register  is succesfully');
    }

    public function logout()
    {
        $langCode = session('language_code', app()->getLocale());

        Auth::logout();

        return redirect()->route('lang.index', ['lang' => $langCode])->with('message', 'logout is succesfully');
    }

    public function profile()
    {
        return view('profile');
    }

    public function update(Request $request, $lang)
    {
        app()->setLocale($lang);
        $langCode = session('language_code', 'en');

        $user = auth()->user();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $user->clearMediaCollection('image');
            $user->addMediaFromRequest('image')->toMediaCollection('image');
        }

        $user->update($request->only('name', 'email', 'phone'));

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $user = auth()->user();

        $user->clearMediaCollection('image');

        $user->addMediaFromRequest('image')->toMediaCollection('image');

        return response()->json([
            'status' => 'success',
            'image_url' => $user->getFirstMediaUrl('image'),
        ]);
    }
}
