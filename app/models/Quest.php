<?php

class Quest extends Eloquent
{

    public function user()
    {
        return $this->belongsTo('User');
    }
    
    /**
     * Возвращает модель "квеста" (задания) по токену
     * @param $host_name
     * @return mixed
     */
    public static function getQuestByToken($quest_token)
    {
        return self::where('token', '=', $quest_token)->first();
    }
    
    
    /**
    * Закрывает "квест" (задание)
    * 
    * @param mixed $params
    */
    public function questClose($post_id, $visitor_id)
    {        
        $this->post_id    = $post_id;
        
        $this->visitor_id = 'VK-' . $visitor_id;
        
        $self = $this;
        
        DB::transaction(function() use ($self){
            
            $self->save();
            
            $user_id = $self->user->id;
            
            $summ = 3;
            
            balanceSheet::credit($user_id, $self->token, $summ);
            
            $self->user->balance = $self->user->balance - $summ;
            
            $self->user()->save();
            
        });
        
    }
    
} 