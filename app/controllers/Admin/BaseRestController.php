<?php

namespace Admin;

class BaseRestController extends \BaseController {
    
    public function __construct()
    {
        $this->beforeFilter(function(){
            if ( \Auth::guest() or ! \Auth::user()->hasRole(\User::ADMIN_ROLE_NAME) ) {
                return array('error' => 'Access denied');
            }
        });
    }

}
