<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\throwException;

class SessionController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email',],
            'password' => ['required']
        ]);

        if(! Auth::attempt($attributes)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match.'],
            ]);
        }

        $request->session()->regenerate();

        return redirect('/home');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }

}
