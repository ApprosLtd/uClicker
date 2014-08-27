<?php

class Merchant extends Eloquent {

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token', 'roles'];

    public static function get()
    {
        return User::get()->filter(function($user)
        {
            return $user->isMerchant();
        });
    }

} 