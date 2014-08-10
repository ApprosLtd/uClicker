<?php

namespace Dashboard;

class BalanceController extends \BaseController
{

	public $layout = 'dashboard.layout';

    public function getIndex()
    {
    	$this->layout->title = 'Баланс';

        $this->layout->content = \View::make('dashboard.balance.index', array(
            'balance' => $this->user()->balance,
            'balance_sheet' => $this->user()->balanceSheet
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