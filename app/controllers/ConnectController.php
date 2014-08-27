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
            Log::warning('Выполнен запрос с заблокированного домена ' . $host, ['user' => $user->toArray()]);
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

        $quest_token = \Quest::open([
            'text'    => $text,
            'href'    => $href,
            'site_id' => $site->id,
            'user_id' => $user->id,
        ]);

        return View::make('frame.index', [
            'text' => $text,
            'href' => $href,
            'quest_token' => $quest_token,
        ]);
    }


    /**
    * Завершает процесс размещения поста
    */
    public function getSuccess()
    {
        $post_id     = Input::get('post_id');
        $visitor_uid = Input::get('visitor_uid');
        $vendor_code = Input::get('vendor_code');
        $quest_token = Input::get('token');
        
        if ($post_id < 1 or $visitor_uid < 1 or empty($quest_token)) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'error' => 'Неверные параметры запроса']);
        }
        
        $quest = \QuestHelper::getQuestByToken($quest_token);
        
        if (!$quest) {
            Log::error('Не найден квест(задание) для токена', ['quest_token' => $quest_token]);
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'error' => 'Неверные параметры запроса']);
        }
        
        if ($quest->post_id > 0) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'info' => 'Данная задача уже закрыта']);
        }
        
        if ( ! \QuestHelper::checkPost($visitor_uid, $post_id) ) {
            Log::error('Попытка закрыть квест для неопубликованного поста', ['visitor_id' => $visitor_uid, 'post_id' => $post_id]);
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'error' => 'Пост не опубликован']);
        }
        
        $visitor_obj = \VisitorHelper::getVisitorByUid($visitor_uid, $vendor_code);
        
        if (!$visitor_obj) {
            Log::error('Ошибка идентификации визитёра', ['visitor_id' => $visitor_uid]);
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'error' => 'Ошибка идентификации визитёра']);
        }       
        
        $quest->close($visitor_obj->id, $post_id);
        
        $data = [
            'success' => true
        ];

        return \Illuminate\Support\Facades\Response::json($data);
    }

} 