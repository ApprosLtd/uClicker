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

    public function getBalance()
    {
        $this->layout->title = 'Баланс';

        $this->layout->content = View::make('dashboard.balance.index', array(
            'balance' => $this->user()->balance
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

} 