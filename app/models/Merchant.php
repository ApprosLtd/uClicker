<?php

class Merchant extends Eloquent {

    protected $table = 'users';

    protected $hidden = array('password', 'remember_token', 'roles');

    public static function get()
    {
        return User::get()->filter(function($user)
        {
            return $user->isMerchant();
        });
    }

} 