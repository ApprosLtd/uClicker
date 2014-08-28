<?php

class HomeController extends BaseController {

    public $layout = 'home.layout';

	public function anyIndex()
	{
        //
	}

    public function getInfo()
    {
        return View::make('home.info');
    }

    public function getSites()
    {
        return Redirect::to('/');
    }

    public function getVisitors()
    {
        return Redirect::to('/');
    }

    public function getBalance()
    {
        return Redirect::to('/');
    }

    public function getStatistics()
    {
        return Redirect::to('/');
    }

    public function getHelp()
    {
        return Redirect::to('/');
    }

    public function getSupport()
    {
        return Redirect::to('/');
    }

    public function getProfile()
    {
        return Redirect::to('/');
    }

    public function getCollections()
    {
        return Redirect::to('/');
    }

}
