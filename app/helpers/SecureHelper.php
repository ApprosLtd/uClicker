<?php

class SecureHelper
{
    
    public static function makeToken()
    {
        $token = uniqid('', true);        
        return sha1($token);
    }
    
}
