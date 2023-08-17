<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
      $index = 1;
      $roles = Role::get();
      return view('roles.index', compact('index','roles'));
    }

    public function create()
    {
       return view('roles.create');
    }
    public function store(Request $request)
    {
        $role = Role::create($request->all());
        return redirect(url('roles'));
    }

}
