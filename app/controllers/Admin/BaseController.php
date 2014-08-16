<?php

namespace Admin;

class BaseController extends \BaseController
{
    public $layout = 'admin.layout';
    
    public function __construct()
    {
        $this->beforeFilter(function(){
            if ( \Auth::guest() or ! \Auth::user()->hasRole(\User::ADMIN_ROLE_NAME) ) {
                return 'Access denied';
            }
        });
    }
    
}
