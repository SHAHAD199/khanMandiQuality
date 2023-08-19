<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Users\{
GetUserService, PostUserService
};

use Illuminate\Http\Request;

class UserController extends Controller
{
  
    private $getUserService;
    private $postUserService;

    public function __construct(GetUserService $getUserService, PostUserService $postUserService)
    {
      $this->getUserService = $getUserService;
      $this->postUserService = $postUserService;
    } 
    public function index()
    {
      return $this->getUserService->index();
    }
    
    public function create()
    {     
        return $this->getUserService->create();
    }

    public function store(Request $request)
    {
       return $this->postUserService->store($request);
    }

    public function edit(User $user)
    {
      return $this->getUserService->edit($user);
    }

    public function update(Request $request, User $user)
    {
      return $this->postUserService->update($request,$user);
    }

    public function delete(User $user)
    {
      return $this->postUserService->delete($user);
    }

   
}
