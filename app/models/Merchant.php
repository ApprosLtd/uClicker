<?php

class Merchant extends Eloquent {

    protected $table = 'users';

    protected $hidden = array('password', 'remember_token');

} 