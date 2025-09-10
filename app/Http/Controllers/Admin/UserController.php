<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show all users
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Toggle admin role
    public function toggleAdmin(User $user)
    {
        $user->is_admin = !$user->is_admin;
        $user->save();

        return redirect()->route('admin.users.index')
                         ->with('success', $user->name . ' is now ' . ($user->is_admin ? 'an Admin' : 'a regular user'));
    }
}
