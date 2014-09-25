<?php

class ConnectController extends BaseController {

    /**
    * Начало процесса размещения поста
    */
    public function getFrame()
    {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            return 'Домен не определен';
        }

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

        $title = Input::get('title');
        $text  = Input::get('text');
        $href  = Input::get('href');
        $image = Input::get('image');

        $quest_token = \Quest::open([
            'text'    => $text,
            'href'    => $href,
            'site_id' => $site->id,
            'user_id' => $user->id,
        ]);

        return View::make('frame.index', [
            'title' => $title,
            'text'  => $text,
            'href'  => $href,
            'image' => $image,
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

    protected function getVkAccessToken()
    {
        $client_id = '4335971';
        $client_secret = 'NpeRSX0f5Lj3DzGR2j0z';

        $url = 'https://oauth.vk.com/access_token?client_id=' . $client_id . '&client_secret=' . $client_secret . '&v=5.24&grant_type=client_credentials';

        $response = file_get_contents($url);

        $json_data = json_decode($response);

        if (isset($json_data->access_token) and !empty($json_data->access_token)) {
            return $json_data->access_token;
        }

        return null;
    }

    protected function getVkUploadUrl($user_id)
    {
        $api_url = 'https://api.vk.com/method/photos.getWallUploadServer';

        $params = [
            'user_id' => $user_id,
            'access_token' => $this->getVkAccessToken(),
            //'v' => '5.24'
        ];

        $curl = curl_init($api_url);
        curl_setopt ($curl, CURLOPT_POST, 1);
        curl_setopt ($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }


    /**
     * Загружает картинку на сервер Вконтакте и возвращает ответ от сервера
     * @return json
     */
    public function anyUploadPhoto()
    {
        $image_url = Input::get('image_url');
        $user_id   = Input::get('user_id');
        $upload_url = Input::get('upload_url');

        $resources_directory = $_SERVER['DOCUMENT_ROOT'] . '/res/';

        $tmp_img_name = md5($user_id . microtime()) . '.jpg';

        file_put_contents($resources_directory . $tmp_img_name, file_get_contents($image_url));

        $curl_file = new CURLFile($resources_directory . $tmp_img_name,'image/jpeg');

        $curl = curl_init($upload_url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: multipart/form-data']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ['photo' => $curl_file]);
        $response = curl_exec($curl);

        if (!$response) {
            $response = [
                'error' => curl_error($curl) . ' (' . curl_errno($curl) . ')'
            ];
        }

        curl_close($curl);

        return $response;
    }

} 