<?php 

namespace App\Services\Users;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;

class GetUserService 
{
   public static function index()
   {
    $index = 1;
    $users = User::get();
    return view('users.index', compact('index', 'users'));
   }


   public static function create()
   {
    $roles = Role::get();
    $branches = Branch::get();
    return view('users.create', compact('roles', 'branches'));
   }

   public function edit(User $user)
   {
     $roles = Role::get();
     $branches = Branch::get();
    return view('users.edit', compact('user','roles','branches'));
   }
}