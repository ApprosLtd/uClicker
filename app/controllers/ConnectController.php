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

        if ($site->isBlocked()) {
            Log::warning('Выполнен запрос с заблокированного домена ' . $host, array('user' => $user->toArray()));
            return View::make('frame.lost-host');
        }

        if (!$user) {
            Log::error('Не найден пользователя для домена', $site->toArray());
            return View::make('frame.error');
        }

        if (!$user->checkBalance()) {
            Log::info('Баланс партнера на нуле', $user->toArray());
            return View::make('frame.low-balance');
        }

        $text       = Input::get('text');
        $href       = Input::get('href');

        $quest_token = $user->questOpen(array(
            'text'    => $text,
            'href'    => $href,
            'site_id' => $site->id,
        ));

        return View::make('frame.index', array(
            'text' => $text,
            'href' => $href,
            'quest_token' => $quest_token,
        ));
    }


    public function getSuccess()
    {
        $http_referer = $_SERVER['HTTP_REFERER'];

        $parse_url = parse_url($http_referer);

        $host = null;

        if (isset($parse_url['host']) and !empty($parse_url['host'])) {
            $host = $parse_url['host'];
        }

        $site = Site::getSiteByHostName($host);

        if (!$site) {
            Log::error('Выполнен запрос с незарегистрированного домена 2233 ' . $host);
            return \Illuminate\Support\Facades\Response::json(array('error' => '2233'));
        }

        $user = $site->user;

        if (!$user) {
            Log::error('Не найден пользователя для домена 2244', $site->toArray());
            return \Illuminate\Support\Facades\Response::json(array('error' => '2244'));
        }
        
        $post_id     = Input::get('post_id');
        $visitor_id  = Input::get('visitor_id');
        $quest_token = Input::get('quest_token');
        
        if ($post_id > 0 and $visitor_id > 0 and !empty($quest_token)) {
            
            $user->questClose(array(
                'post_id'    => $text,
                'visitor_id' => $href,
                'token'      => $quest_token,
            ));
            
            $data = array(
                'success' => true
            );
        } else {
            //
        }

        return \Illuminate\Support\Facades\Response::json($data);
    }

} 