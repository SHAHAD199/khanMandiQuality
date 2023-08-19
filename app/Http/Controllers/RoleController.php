<?php

namespace App\Http\Controllers;

use App\Services\Roles\{
  GetRoleService,PostRoleService
};

use Illuminate\Http\Request;

class RoleController extends Controller
{

    private $getRoleService;
    private $postRoleService;
    public function __construct(GetRoleService $getRoleService, PostRoleService $postRoleService)
    {
      $this->getRoleService = $getRoleService;
      $this->postRoleService = $postRoleService;
    }

    public function index()
    {
      return $this->getRoleService->index();
    }

    public function create()
    {
       return $this->getRoleService->create();
    }

    public function store(Request $request)
    {
      return $this->postRoleService->store($request);
    }

}
