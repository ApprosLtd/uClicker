<?php

class QuestHelper
{

    /**
     * Возвращает модель "квеста" (задания) по токену
     * @param $host_name
     * @return mixed
     */
    public static function getQuestByToken($quest_token)
    {
        return \Quest::where('token', '=', $quest_token)->first();
    }
    
    
    public static function checkPost($visitor_id, $post_id)
    {
        $url = "https://api.vk.com/method/wall.getById?posts={$visitor_id}_{$post_id}";
        
        $response_json = file_get_contents($url);
        
        $response_mix  = json_decode($response_json);
        
        if (isset($response_mix['response']) and isset($response_mix['response']->id) and $response_mix['response']->id == $post_id) {
            return true;
        }
        
        return false;
    }
    
} 