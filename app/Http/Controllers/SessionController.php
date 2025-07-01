<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
    public function store(SessionRequest $request)
    {
        $attributes = $request->validated();

        if(! Auth::attempt($attributes)){
            throw ValidationException::withMessages([
                'email' => ['اطلاعات وارد شده غلط میباشد.'],
            ]);
        }

        $request->session()->regenerate();

        return redirect('/');

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
