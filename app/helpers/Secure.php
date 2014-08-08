<?php

class Secure
{
    
    public static function makeToken()
    {
        $token = uniqid('', true);        
        return sha1($token);
    }
    
}
