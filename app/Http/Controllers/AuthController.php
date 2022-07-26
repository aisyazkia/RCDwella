<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email',$request->email)->first();
        if(!$user){
            return redirect()->route('auth.login')->withErrors(['error' => 'Email atau Password yang anda masukkan salah.']);
        }

        if(!Hash::check($request->password, $user->password))
        {
            return redirect()->route('auth.login')->withErrors(['error' => 'Email atau Password yang anda masukkan salah.']);
        }

        Auth::login($user);
        if($user->level->primary == 'YES')
        {
            return redirect()->route('admin.dashboard.index');            
        }
        return redirect()->route('home');            

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User,email',
            'phone' => 'required|numeric',
            'address' => 'required|min:3',
            'password' => 'required|min:5',
            'password_confirmation' => 'required|same:password'
        ]);

        $sv = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'level_id' => 2
        ]);
        if($sv)
        {
            return redirect()->route('auth.login')->with('success','Berhasil mendaftar silahkan login');
        }

        return redirect()->route('auth.register')->withErrors(['error' => 'Gagal mendaftar.']);

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
