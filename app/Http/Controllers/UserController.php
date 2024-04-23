<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;

class UserController extends Controller
{
   
    public function index()
    {
        $users = User::with('roles')->get();
        return Inertia::render('Forum/users', [
            'users' => $users
        ]);
        
    }

    public function create()
    {
        $roles = Role::all();
        return Inertia::render('Users/Create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('users.index')->with('message', 'User created.');
    }
    

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role_id' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('users.index')->with('message', 'User updated.');
    }
  
    public function destroy(User $user)
    {
        if ($user->is_active == false) {
            $user->is_active = true;
            $user->save();
            return redirect()->route('users.index')->with('message', 'User activated.');
        } else {
            $user->is_active = false;
            $user->save();
            return redirect()->route('users.index')->with('message', 'User deactivated.');
        }
    }
}
