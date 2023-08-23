<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name'     => ['required', 'string', 'max:255'],
            "phone"    => ['required','string','max:11','regex:/(07)[0-9]{9}/','unique:users'],
            'password' =>   $this->passwordRules(),
            'role_id'  =>  ['integer', 'required', 'exists:roles,id'],
        ])->validate();

        return User::create([
            'name'     => $input['name'],
            'phone'    => $input['phone'],
            'role_id'  => $input['role_id'],
            'password' => $input['password'],
        ]);
    }
}
