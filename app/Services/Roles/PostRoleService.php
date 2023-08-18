<?php 

namespace App\Services\Roles;

use App\Models\Role;

class PostRoleService
{
    public static function store($request)
    {
         Role::create($request->all());
        return redirect(url('roles'));
    }

}