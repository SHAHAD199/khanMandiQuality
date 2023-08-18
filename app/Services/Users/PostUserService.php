<?php 

namespace App\Services\Users;

use App\Models\User;

class PostUserService 
{
    public function store($request)
    {
   
       User::create($request->all());
       return redirect(url('users'));
    }

    public function update($request,$user)
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