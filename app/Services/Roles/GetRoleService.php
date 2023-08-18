<?php 

namespace App\Services\Roles;

use App\Models\Role;

class GetRoleService
{
    public static function index()
    {
      $index = 1;
      $roles = Role::get();
      return view('roles.index', compact('index','roles'));
    }

    public static function create()
    {
       return view('roles.create');
    }

}