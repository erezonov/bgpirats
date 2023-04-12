<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function auth(Request $request)
    {

    }

    public function showUsers()
    {
        return view('users.index', ['users' => User::all()]);
    }
}
