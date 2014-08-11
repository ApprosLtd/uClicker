<?php
/**
 * Created by PhpStorm.
 * User: Vitaly
 * Date: 31.07.14
 * Time: 16:40
 */

class DashboardController extends BaseController {

    public $layout = 'dashboard.layout';

    public function getIndex()
    {
        $this->layout->title = 'Главная';

        $this->layout->content = View::make('dashboard.index.index');
    }

    public function getSites()
    {
        $this->layout->title = 'Сайты';

        $this->layout->content = View::make('dashboard.sites.index', array(
            'sites' => $this->user()->sites
        ));
    }

    public function getVisitors()
    {
        $this->layout->title = 'Посетители';

        $this->layout->content = View::make('dashboard.visitors.index', array(
            'visitors' => $this->user()->visitors()
        ));
    }

    public function getStatistics()
    {
        $this->layout->title = 'Статистика';

        $this->layout->content = View::make('dashboard.statistics.index');
    }

    public function getHelp()
    {
        $this->layout->title = 'Справочник';

        $this->layout->content = View::make('dashboard.help.index');
    }

    public function getSupport()
    {
        $this->layout->title = 'Техническая поддержка';

        $this->layout->content = View::make('dashboard.support.index');
    }

    public function getProfile()
    {
        $this->layout->title = 'Профиль пользователя';

        $this->layout->content = View::make('dashboard.profile.index');
    }

    public function postData()
    {
        $from_date = Input::get('from_date');
        $to_date   = Input::get('to_date');
        $target    = Input::get('target');
        $page      = Input::get('page', 1);

        $model = ucfirst($target);

        $rows = $model::where('created_at', '>=', $from_date)->where('created_at', '<=', $to_date)->get();

        //$rows = array();

        return \Response::json($rows->toArray());
    }

} 