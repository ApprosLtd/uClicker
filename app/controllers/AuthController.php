<?php

class AuthController extends BaseController {

    public function anyLogin()
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


    public function anyLogout()
    {
        Auth::logout();

        return Redirect::to('/');
    }

} 