<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    /**
     * show all the users
     */
    public function show_all_users(){
        $users = User::latest()->paginate(30);
        $userCount = User::count();

        return view('dashboard.users.index', compact('users'))
            ->with('userCount', $userCount)
            ->with('f',1)
            ->with('i', (request()->input('page',1) - 1) * 30);
    }
}
