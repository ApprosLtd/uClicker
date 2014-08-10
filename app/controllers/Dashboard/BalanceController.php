<?php

namespace Dashboard;

class BalanceController extends \BaseController
{

	public $layout = 'dashboard.layout';

    public function getIndex()
    {
    	$this->layout->title = 'Баланс';
        
        $sql = "select q.site_id, s.domain, sum(b.credit) as summa, count(q.id) as posts from quests as q join balance_sheet as b join sites as s on q.token = b.quest_token where s.id = q.site_id and q.user_id = b.user_id and q.user_id = ? group by q.site_id";
        
        $balance_sheet_credit = DB::select($sql, array($this->user()->id));

        $this->layout->content = \View::make('dashboard.balance.index', array(
            'balance' => $this->user()->balance,
            'balance_sheet' => $this->user()->balanceSheet()->where('debet', '>', 0)->get(),
            'balance_sheet_credit' => $balance_sheet_credit
        ));
    }

	public function getReplenishment()
	{
		$summ = \Input::get('summ');

		$user_id = $this->user()->id;

		\BalanceSheet::debet($user_id, $summ, 'Пополнение через терминал');

		return \Redirect::to('/balance');
	}
}