<?php

class HomeController extends BaseController {

    public $layout = 'home.layout';

    public function __construct()
    {
        $email    = Input::get('email');
        $password = Input::get('password');        

        if ($email) {

            $user = User::where('email', '=', $email)->first();

            if ($user) { // Если пользователь есть, то пытаемся авторизоваться

                if (Auth::attempt(array('email' => $email, 'password' => $password))) {
                    return Redirect::to('/');
                } else {
                    echo 'Неверный логин или пароль - ' . Crypt::decrypt($user->password);
                }

            } else { // Если пользователя нет, то регистрируем нового пользователя

                $user = new User();

                $user->email = $email;
                $user->password = Hash::make($password);

                $user->save();

                Auth::login($user);

                return Redirect::to('/');

            }

        }
    }

	public function anyIndex()
	{
        //$user = User::where('email', '=', 'serovvitaly@gmail.com')->first();
        
        //Auth::login($user);
        
        var_dump( Auth::check() );
	}

}
