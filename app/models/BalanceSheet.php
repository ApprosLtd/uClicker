<?php

class BalanceSheet extends Eloquent
{
    protected $table = 'balance_sheet';
    
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    
    /**
    * Кредит, расход портнера
    * @param mixed $user_id
    * @param mixed $summ
    */
    public static function credit($user_id, $quest_token, $summ)
    {
        $accounting_operation = new self;
        
        $accounting_operation->user_id = $user_id;
        
        $accounting_operation->credit  = $summ;
        
        $accounting_operation->quest_token  = $quest_token;
        
        $accounting_operation->save();
        
        return $accounting_operation->id;
    }
    
    
    /**
    * Дебет, приход партнера
    * @param mixed $user_id
    * @param mixed $summ
    */
    public static function debet($user_id, $summ, $comment = '')
    {
        
        $accounting_operation = new self;
        
        $accounting_operation_id = DB::transaction(function() use ($user_id, $summ, $comment, $accounting_operation){
            
            $user = User::find($user_id);
            
            if (!$user) {
                Log::error('Попытка пополнить баланс несуществующего пользователя - ' . $user);
                return false;
            }
            
            $user->balance = $user->balance + $summ;
            
            $accounting_operation->user_id = $user_id;
            
            $accounting_operation->debet   = $summ;
            
            $accounting_operation->comment = $comment;
            
            $accounting_operation->save();
            
            $user->save();
            
            return $accounting_operation->id;
            
        });
        
        return $accounting_operation_id;
    }
}