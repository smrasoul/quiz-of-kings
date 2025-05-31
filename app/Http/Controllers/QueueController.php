<?php

namespace App\Http\Controllers;

use App\Models\GameQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    public function test()
    {
        $userId = Auth::id();


        return view('games.create');

    }
}
