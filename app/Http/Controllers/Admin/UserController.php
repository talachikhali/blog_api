<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\user;
use File;
use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereNot('id' , auth()->id())->get();
        return view('users.index' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('/images/users' , 'public');
        } else {
            $imageName = null;
        }
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
            'roleName' => 'exists:roles,name'
        ]);
        $user = user::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image' => $imageName
            ]
        );
        if($request->role == 'admin'){
            $user->assignRole('admin');
        }
        else{
            $user->assignRole('user');
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show( User $user)
    {
        return view('users.show', compact('user'));
        
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('/images/users' , 'public');
            if (Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
        } else {
            $imageName = $user->image;
        }
        if (isset($request->password)) {
            $pw = $request->password;
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|',
                'password' => 'required|string|min:8|confirmed'
            ]);
        }else{
            $pw = $user->password;
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|'
            ]);
        }
        $user->where('id', $user->id)->update([
            "name" => $request->name,
            'email' => $request->email,
            'password' => $pw,
            'image' => $imageName
        ]);

        return redirect()->route('users.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();
        return redirect()->route('users.index');
    
    }

    public function blockUser(User $user)
    {
        $user->removeRole('user');
        return redirect()->route('users.index');
    }

    public function unblockUser(User $user)
    {
        $user->assignRole('user');
        return redirect()->route('users.index');
    }
}
