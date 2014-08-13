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

        if ($from_date > 0) {
            $from_date = date('Y-m-d 00:00:00', strtotime($from_date));
        }

        if ($to_date > 0) {
            $to_date = date('Y-m-d 23:59:59', strtotime($to_date));
        }

        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $output = array(
            'count'  => 0,
            'page'   => $page,
            'limit'  => $limit,
            'offset' => $offset,
            'rows'   => array()
        );

        switch ($target) {
            case 'balance_sheet':
                $rows_obj = $this->user()->balanceSheet()->where('debit', '>', 0);
                if ($from_date > 0) {
                    $rows_obj = $rows_obj->where('created_at', '>=', $from_date);
                }
                if ($to_date > 0) {
                    $rows_obj = $rows_obj->where('created_at', '<=', $to_date);
                }
                $output['count'] = $rows_obj->count();
                $output['rows']  = $rows_obj->offset($offset)->limit($limit)->get();
                break;
            case 'balance_sheet_credit':
                $sql = "select q.site_id, s.domain, sum(b.credit) as summa, count(q.id) as posts from quests as q join balance_sheet as b join sites as s on q.token = b.quest_token where s.id = q.site_id and q.user_id = b.user_id and q.user_id = ? group by q.site_id";

                $output['rows'] = \DB::select($sql, array($this->user()->id));

                break;
            case '':
                //
                break;
        }

        //$output['sqls'] = DB::getQueryLog();

        return \Response::json($output);
    }

} 