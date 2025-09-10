<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        // Validate user data
        $userData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Create customer first and get the customer_id
        $customer_id = DB::table('customer')->insertGetId([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password_hash' => Hash::make($userData['password']),
            'guest_flag' => 0, // 0 = registered user, 1 = guest

        ]);
    
        // Create user with the customer_id
        $user = User::create([
            'customer_id' => $customer_id,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            // other user fields if any...
        ]);
    
        // Log the user in
        Auth::login($user);
    
        return redirect()->route('dashboard');
    }
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // ✅ Redirect based on is_admin
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials provided.',
    ]);
}

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    
}
