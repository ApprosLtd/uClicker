<?php

class ConnectController extends BaseController {

    public function getFrame()
    {
        $http_referer = $_SERVER['HTTP_REFERER'];

        $parse_url = parse_url($http_referer);

        $host = null;

        if (isset($parse_url['host']) and !empty($parse_url['host'])) {
            $host = $parse_url['host'];
        }

        $site = Site::getSiteByHostName($host);

        if (!$site) {
            Log::error('Выполнен запрос с незарегистрированного домена ' . $host);
            return View::make('frame.lost-host');
        }

        $user = $site->user;

        if ($site->isBlocked) {
            Log::error('Выполнен запрос с заблокированного домена ' . $host, array('user' => $user->toArray()));
            return View::make('frame.lost-host');
        }

        if (!$user->checkBalance()) {
            Log::info('Баланс партнера на нуле', $user->toArray());
            return View::make('frame.low-balance');
        }

        $quest = new Quest();

        $quest->


        $text = Input::get('text');
        $href = Input::get('href');

        return View::make('frame.index', array(
            'text' => $text,
            'href' => $href,
        ));
    }


    public function getSuccess()
    {
        $post_id = Input::get('post_id');

        $data = array(
            'success' => true
        );

        return \Illuminate\Support\Facades\Response::json($data);
    }

} 