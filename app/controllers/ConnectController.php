<?php

class ConnectController extends BaseController {

    public function getFrame()
    {
        $http_referer = $_SERVER['HTTP_REFERER'];

        $parse_url = parse_url($http_referer);

        print_r($parse_url);

        $text = Input::get('text');
        $href = Input::get('href');

        return View::make('frame', array(
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