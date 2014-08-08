<?php

class ConnectController extends BaseController {

    public function getFrame()
    {
        print_r($_SERVER);

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