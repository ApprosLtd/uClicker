<?php

class ConnectController extends BaseController {

    /**
    * Начало процесса размещения поста
    */
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

        $quest_token = \Quest::open(array(
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


    /**
    * Завершает процесс размещения поста
    */
    public function getSuccess()
    {
        $post_id     = Input::get('post_id');
        $visitor_uid = Input::get('visitor_uid');
        $quest_token = Input::get('token');
        
        if ($post_id < 1 or $visitor_uid < 1 or empty($quest_token)) {
            return \Illuminate\Support\Facades\Response::json(array('success' => false, 'error' => 'Неверные параметры запроса'));
        }
        
        $quest = \QuestHelper::getQuestByToken($quest_token);
        
        if (!$quest) {
            Log::error('Не найден пользователя для домена', $site->toArray());
            return \Illuminate\Support\Facades\Response::json(array('success' => false, 'error' => 'Неверные параметры запроса'));
        }
        
        if ($quest->post_id > 0) {
            return \Illuminate\Support\Facades\Response::json(array('success' => false, 'info' => 'Данная задача уже закрыта'));
        }
        
        if ( ! \QuestHelper::checkPost($visitor_uid, $post_id) ) {
            Log::error('Попытка закрыть квест для неопубликованного поста', array('visitor_id' => $visitor_uid, 'post_id' => $post_id));
            return \Illuminate\Support\Facades\Response::json(array('success' => false, 'error' => 'Пост не опубликован'));
        }
        
        $visitor_obj = \VisitorHelper::getVisitorByUid($visitor_uid); 
        
        if (!$visitor_obj) {
            Log::error('Ошибка идентификации визитёра', array('visitor_id' => $visitor_uid));
            return \Illuminate\Support\Facades\Response::json(array('success' => false, 'error' => 'Ошибка идентификации визитёра'));
        }       
        
        $quest->close($visitor_obj->id, $post_id);
        
        $data = array(
            'success' => true
        );

        return \Illuminate\Support\Facades\Response::json($data);
    }

} 