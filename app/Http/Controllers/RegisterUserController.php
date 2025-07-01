<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;

class RegisterUserController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());

        Auth::login($user);

        return redirect('/');
    }

}
