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

        $this->layout->content = View::make('dashboard.sites.index', [
            'sites' => $this->user()->sites
        ]);
    }

    public function getVisitors()
    {
        $this->layout->title = 'Посетители';

        $this->layout->content = View::make('dashboard.visitors.index', [
            'visitors' => $this->user()->visitors()
        ]);
    }

    public function getStatistics()
    {
        $this->layout->title = 'Статистика';

        $this->layout->content = View::make('dashboard.statistics.index');
    }

    public function getHelp()
    {
        $this->layout->title = 'Справочник';
        
        $markdown = Markdown::make('hello');
        
        $menu = [
            ['text' => 'Введение', 'href' => 'intro'],
            ['text' => 'Принцип работы', 'href' => ''],
            ['text' => 'Подключение скриптов', 'href' => ''],
            ['text' => 'Контроль объявлений', 'href' => ''],
        ];

        $this->layout->content = View::make('dashboard.help.index', [
            'markdown' => $markdown,
            'menu'     => $menu,
            'current'  => 'intro'
        ]);
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
        $page      = intval(Input::get('page', 1));

        if ($from_date > 0) {
            $from_date = date('Y-m-d 00:00:00', strtotime($from_date));
        }

        if ($to_date > 0) {
            $to_date = date('Y-m-d 23:59:59', strtotime($to_date));
        }

        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $output = [
            'total'  => 0,
            'page'   => $page,
            'limit'  => $limit,
            'offset' => $offset,
            'pagination_html' => '',
            'rows'   => []
        ];

        switch ($target) {
            case 'balance_sheet':
                $rows_obj = $this->user()->balanceSheet()->where('debit', '>', 0);
                if ($from_date > 0) {
                    $rows_obj = $rows_obj->where('created_at', '>=', $from_date);
                }
                if ($to_date > 0) {
                    $rows_obj = $rows_obj->where('created_at', '<=', $to_date);
                }


                $total_items = $rows_obj->count();
                $output['total'] = $total_items;

                $rows_obj_arr = $rows_obj->offset($offset)->limit($limit)->get()->toArray();
                $output['rows']  = $rows_obj_arr;

                $output['pagination_html'] = (string) Paginator::make($rows_obj_arr, $total_items, $limit)->links();

                break;
                
                
            case 'balance_sheet_credit':
                $sql = "SELECT q.site_id, s.domain, SUM(b.credit) AS summa, COUNT(q.id) AS posts FROM quests AS q JOIN balance_sheet AS b JOIN sites AS s ON q.token = b.quest_token WHERE s.id = q.site_id AND q.user_id = b.user_id AND q.user_id = ? GROUP BY q.site_id";

                $output['rows'] = \DB::select($sql, [$this->user()->id]);

                break;
                
                
            case 'tickets':
                
                $rows_obj = $this->user()->tickets()->where('priority_id', '>', 0);
                if ($from_date > 0) {
                    $rows_obj = $rows_obj->where('created_at', '>=', $from_date);
                }
                if ($to_date > 0) {
                    $rows_obj = $rows_obj->where('created_at', '<=', $to_date);
                }


                $total_items = $rows_obj->count();
                $output['total'] = $total_items;

                $rows_obj_arr = $rows_obj->offset($offset)->limit($limit)->orderBy('created_at', 'DESC')->get();
                $rows = [];
                foreach ($rows_obj_arr as $row_obj) {

                    $created_at = date('d.m.Y в H:i', strtotime($row_obj->created_at));

                    $current_mix = [
                        'id'             => $row_obj->id,
                        'title'          => $row_obj->title,
                        'created_at'     => $created_at,
                        'category_title' => '',
                        'content'        => $row_obj->content,
                        'priority_title' => '',
                        'priority_color' => '',
                        'status'         => 'В работе',
                    ];

                    $category = $row_obj->category;
                    if ($category) {
                        $current_mix['category_title'] = $category->title;
                    }

                    $priority = $row_obj->priority;
                    if ($priority) {
                        $current_mix['priority_title'] = $priority->title;
                        $current_mix['priority_color'] = $priority->color;
                    }

                    $rows[] = $current_mix;
                }
                $output['rows']  = $rows;

                $output['pagination_html'] = (string) Paginator::make($rows_obj_arr->toArray(), $total_items, $limit)->links();
                
                break;
                
                
            case '':
                //
                break;
        }

        //$output['sqls'] = DB::getQueryLog();

        return \Response::json($output);
    }

} 