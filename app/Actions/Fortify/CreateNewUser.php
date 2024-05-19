<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
            'name' => ['required', 'string', 'max:255'],
            'last_legal_name' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_type_id'=>['required', 'integer'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user= User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        if($user->exists()){
            UserDetail::create([
                'first_name' => $input['name'],
                'last_legal_name' => $input['last_legal_name'],
                'user_type_id' => $input['user_type_id'],
                'user_id'=> $user->id
            ]);

            $user->assignRole('clientRole');
        }


        return $user;

    }
}
