<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomUserProvider extends EloquentUserProvider {

    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password']; // will depend on the name of the input on the login form
        $hashedValue = $user->getAuthPassword();
        if ($this->hasher->needsRehash($hashedValue) && $hashedValue === strtoupper(md5(mb_convert_encoding(request('password'),'cp1251')))) {
            $user->password = bcrypt($plain);
            $user->save();
        }

        return $this->hasher->check($plain, $user->getAuthPassword());
    }

}