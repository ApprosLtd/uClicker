<?php

class HomeController extends BaseController {

    public $layout = 'home.layout';

	public function anyIndex()
	{
        //
	}

    public function getSites()
    {
        return Redirect::to('/');
    }

    public function getMerchants()
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

}
