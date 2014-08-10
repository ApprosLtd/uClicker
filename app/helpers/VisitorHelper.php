<?php

class VisitorHelper
{
    public static function getVisitorByUid($visitor_uid, $vendor = 'VK')
    {
        $vendor = trim($vendor);
        $vendor = strtoupper($vendor);
        
        $visitor_obj = \Visitor::where('uid', '=', $visitor_uid)->where('vendor', '=', $vendor)->first();
        
        if (!$visitor_obj) {
            
            $visitor_obj = new \Visitor();
            
            $visitor_obj->uid    = $visitor_uid;
            
            $visitor_obj->vendor = $vendor;
            
            
            $url = "https://api.vk.com/method/users.get?user_ids={$visitor_uid}&fields=sex,bdate,city,country";
            
            $response_json = file_get_contents($url);
        
            $response_mix  = json_decode($response_json);
            
            $visitor_obj->first_name = $response_mix['response']->first_name;
            
            $visitor_obj->last_name  = $response_mix['response']->last_name;
            
            $visitor_obj->sex        = $response_mix['response']->sex;
            
            $visitor_obj->birthday   = '';
            
            
            $visitor_obj->save();
        }
        
        return $visitor_obj;
    }
}