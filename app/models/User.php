<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
    
    const ADMIN_ROLE_NAME = 'admin';

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

    public function roles()
    {
        return $this->belongsToMany('Role', 'users_roles');
    }
    
    public function hasRole($check)
    {
        return in_array($check, array_fetch($this->roles->toArray(), 'name'));
    }
    
    /**
     * Find out if User is an employee, based on if has any roles
     *
     * @return boolean
     */
    public function isEmployee()
    {
        $roles = $this->roles->toArray();
        return !empty($roles);
    }
    
    /**
     * Get key in array with corresponding value
     *
     * @return int
     */
    private function getIdInArray($array, $term)
    {
        foreach ($array as $key => $value) {
            if ($value == $term) {
                return $key;
            }
        }
 
        throw new UnexpectedValueException;
    }
    
    /**
     * Add roles to user to make them a concierge
     */
    public function makeEmployee($name)
    {
        $assigned_roles = array();
 
        $roles = array_fetch(Role::all()->toArray(), 'name');
 
        switch ($name) {
            case 'super_admin':
                $assigned_roles[] = $this->getIdInArray($roles, 'edit_customer');
                $assigned_roles[] = $this->getIdInArray($roles, 'delete_customer');
            case 'admin':
                $assigned_roles[] = $this->getIdInArray($roles, 'create_customer');
            default:
                throw new \Exception("The employee status entered does not exist");
        }
 
        $this->roles()->attach($assigned_roles);
    }
    
    public function isAdmin()
    {
        return $this->hasRole(self::ADMIN_ROLE_NAME);
    }

    public function sites()
    {
        return $this->hasMany('Site');
    }


    public function quests()
    {
        return $this->hasMany('Quest');
    }


    public function tickets()
    {
        return $this->hasMany('Ticket');
    }


    public function visitors()
    {        
        $sql = "select v.*, count(q.id) as quests  from visitors as v join quests as q  on q.visitor_id = v.id where q.user_id = ? group by q.visitor_id";
        
        $visitors_obj_arr = DB::select($sql, array($this->id));
        
        return $visitors_obj_arr;
    }
    
    
    public function balanceSheet()
    {
        return $this->hasMany('BalanceSheet');
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
    
    /**
    * Обновляет баланс партнера
    */
    public function updateBalance()
    {
        //
    }

}
