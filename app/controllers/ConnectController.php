<?php

class ConnectController extends BaseController {

    /**
    * Выовдит содержимое основного фрейма
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
        $quest_token = Input::get('quest_token');

        \CommonHelper::json_assert(
            ($post_id > 0) and ($visitor_uid > 0) and !empty($quest_token),
            'Неверные параметры запроса',
            'Неверные параметры запроса',
            Input::all()
        );
        
        $quest = \QuestHelper::getQuestByToken($quest_token);
        \CommonHelper::json_assert(
            $quest,
            'Неверно указан токен',
            'Не найден квест(задание) для токена',
            Input::all()
        );

        // Проверяем, не закрыта ли уже задача
        \CommonHelper::json_assert(
            !($quest->post_id > 0),
            'Данная задача уже закрыта',
            'Попытка закрыть уже закрытый квест(задачу)',
            Input::all()
        );

        // Проверяем, опубликован ли пост
        \CommonHelper::json_assert(
            \QuestHelper::checkPost($visitor_uid, $post_id),
            'Пост не опубликован',
            'Попытка закрыть квест для неопубликованного поста',
            Input::all()
        );
        
        $visitor_obj = \VisitorHelper::getVisitorByUid($visitor_uid, $vendor_code);
        \CommonHelper::json_assert(
            $visitor_obj,
            'Ошибка идентификации',
            'Ошибка идентификации визитёра',
            Input::all()
        );
        
        $quest->close($visitor_obj->id, $post_id);

        return \Illuminate\Support\Facades\Response::json(['success' => true]);
    }


    /**
     * Загружает картинку на сервер Вконтакте и возвращает ответ от сервера
     * @return json
     */
    public function anyUploadPhoto()
    {
        $image_url   = Input::get('image_url');
        $user_id     = Input::get('user_id');
        $upload_url  = Input::get('upload_url');
        $quest_token = Input::get('quest_token');

        $quest = \QuestHelper::getQuestByToken($quest_token);
        \CommonHelper::json_assert($quest, 'Неверные параметры запроса', 'Не найден квест(задание) для токена', ['quest_token' => $quest_token]);



        $image_cache_file = $this->pullUploadPhotoCacheFile($image_url);

        $curl_file = new \CURLFile($image_cache_file,'image/jpeg');

        $curl = curl_init($upload_url);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: multipart/form-data']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ['photo' => $curl_file]);

        $response = curl_exec($curl);

        \CommonHelper::json_assert($response, 'Ошибка загрузки файла на VK: ' . curl_error($curl) . ' (' . curl_errno($curl) . ')', null, ['user_id' => $user_id, 'image_url' => $image_url]);

        curl_close($curl);

        return $response;
    }


    /**
     * Возвращает путь к закешированному файлу картинки, если файла нет в кэше, то создает его кэш.
     * @param $image_url
     * @return string
     */
    protected function pullUploadPhotoCacheFile($image_url)
    {
        $image_url = trim($image_url);

        if (empty($image_url)) {
            return false;
        }

        $resources_directory = $_SERVER['DOCUMENT_ROOT'] . '/res/';

        // TODO: сделать определение MIME TYPE для картинки
        $tmp_img_name = md5($image_url) . '.jpg';

        if (!file_exists($resources_directory . $tmp_img_name)) {
            file_put_contents($resources_directory . $tmp_img_name, file_get_contents($image_url));
        }

        return $resources_directory . $tmp_img_name;
    }

} 