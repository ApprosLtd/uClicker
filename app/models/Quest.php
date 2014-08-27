<?php

class Quest extends Eloquent
{

    public function user()
    {
        return $this->belongsTo('User');
    }
    
    
    /**
    * Открывает "квест" (задание)
    * @param mixed $params
    */
    public static function open(array $params)
    {
        $quest_obj = new Quest();
        
        $token = \SecureHelper::makeToken();
        
        $quest_obj->token   = $token;
        $quest_obj->text    = $params['text'];
        $quest_obj->href    = $params['href'];
        $quest_obj->site_id = $params['site_id'];
        
        $user_obj = \User::find($params['user_id']);
        
        if (!$user_obj) {
            Log::error('Не найден пользователя для домена', ['user_id' => $params['user_id'], 'site_id' => $params['site_id']]);
            return false;
        }
        
        $user_obj->quests()->save($quest_obj);
        
        return $token;
    }
    
    
    /**
    * Закрывает "квест" (задание)
    * 
    * @param mixed $params
    */
    public function close($visitor_id, $post_id)
    {        
        $this->post_id    = $post_id;
        
        $this->visitor_id = $visitor_id;

        $self = $this;
        
        DB::transaction(function() use ($self){
            
            $self->save();
            
            $user_id = $self->user->id;
            
            $summ = 3;
            
            BalanceSheet::credit($user_id, $self->token, $summ);
            
            $self->user->balance = $self->user->balance - $summ;
            
            $self->user->save();
            
        });
        
    }
    
} 