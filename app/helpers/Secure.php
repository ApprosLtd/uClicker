<?php

class Secure
{
    
    public static function makeToken()
    {
        $token = uniqid('', true);
        
        $token = str_replace('.', '', $token);
        
        return $token;
    }
    
}
