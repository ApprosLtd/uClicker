<?php

class Site extends Eloquent {

    public function user()
    {
        return $this->belongsTo('User');
    }


    /**
     * Проверка, заблокирован ли сайт
     * @return bool
     */
    public function isBlocked()
    {
        if ($this->user_blocked == 1 or $this->admin_blocked == 1) {
            return true;
        }

        return false;
    }


    /**
     * Возвращает модель сайта по имени хоста
     * @param $host_name
     * @return mixed
     */
    public static function getSiteByHostName($host_name)
    {
        return self::where('domain', '=', $host_name)->first();
    }
} 