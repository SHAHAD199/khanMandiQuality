<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
      $index = 1;
      $users = User::get();
      
      return view('users.index', compact('index', 'users'));
    }
    
    public function create()
    {
        $roles = Role::get();
        $branches = Branch::get();

        return view('users.create', compact('roles', 'branches'));
    }

    public function store(Request $request)
    {
   
       User::create($request->all());
       return redirect(url('users'));
    }

    public function edit(User $user)
    {
      $roles = Role::get();
      $branches = Branch::get();
       return view('users.edit', compact('user','roles','branches'));
    }

    public function update(Request $request, User $user)
    {
      $user->update($request->all());
      return redirect(url('users'));
    }

    public function delete(User $user)
    {
      $user->delete();
      return back();
    }

   
}
