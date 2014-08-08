<?php

class Site extends Eloquent {

    public function user()
    {
        return $this->belongsTo('User');
    }


    /**
     * Блокирование сайта
     */
    public function blocking()
    {
        $this->blocked = 1;
        $this->save();
    }


    /**
     * Разблокирование сайта
     */
    public function unblocking()
    {
        $this->blocked = 0;
        $this->save();
    }

    public static function getSiteByHostName($host_name)
    {
        return self::where('domain', '=', $host_name)->first();
    }
} 