<?php

class ConnectController extends BaseController {

    public function getFrame()
    {
        return View::make('frame', array(
            'text' => Input::get('text'),
            'href' => Input::get('href'),
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