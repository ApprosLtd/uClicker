<?php

class ConnectController extends BaseController {

    public function getFrame()
    {
        return View::make('frame', array(
            'text' => Input::get('text'),
            'href' => Input::get('href'),
        ));
    }

} 