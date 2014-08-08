<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


    public function sites()
    {
        return $this->hasMany('Site');
    }


    public function quests()
    {
        return $this->hasMany('Quest');
    }


    public function visitors()
    {
        return $this->hasMany('Visitor');
    }


    /**
     * Блокирование сайта
     * @param $site_id
     */
    public function blockingSites($site_id)
    {
        $site_obj = $this->sites()->find($site_id);

        if ($site_obj) {
            $site_obj->user_blocked = 1;
            $site_obj->save();
        }
    }


    /**
     * Разблокирование сайта
     * @param $site_id
     */
    public function unblockingSites($site_id)
    {
        $site_obj = $this->sites()->find($site_id);

        if ($site_obj) {
            $site_obj->user_blocked = 0;
            $site_obj->save();
        }
    }


    /**
     * Удаление сайта
     * @param $site_id
     */
    public function removeSites($site_id)
    {
        $site_obj = $this->sites()->find($site_id);

        if ($site_obj) {
            $site_obj->delete();
        }
    }


    /**
     * Проверка баланса партнера
     */
    public function checkBalance()
    {
        if ($this->balance > 0) {
            return true;
        }

        return false;
    }

}
