<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.loginForm');
    }

    public function login(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if($user->hasRole('user') || !$user->hasAnyRole(['user' , 'admin'])){
            return back()->withErrors(['message' => 'doesnt have the rights']);
        }

        if (Auth::attempt(["email" => $request->email, "password" => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        }
        return back()->withErrors(["message" => "invalid email or password"]);

    }
    public function index()
    {
        $users = User::whereNot('id', auth()->id())->get();
        $count_users = User::count();
        $count_categories = Category::count();
        $count_tags = Tag::count();
        
        return view('dashboard.index', compact('users', 'count_users' ,'count_categories','count_tags' ));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    
}
