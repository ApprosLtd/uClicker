<?php

namespace Admin;

class IndexController extends BaseController
{    
    public function getIndex()
    {
        $this->layout->title = 'Админка';
        $this->layout->content = 'АДМИНКА';
    }
    
    public function getMerchants()
    {
        $this->layout->title = 'Партнеры';

        $this->layout->content = \View::make('admin.merchants.index', [
            'title' => $this->layout->title
        ]);
    }
    
    public function getSites()
    {
        $this->layout->title = 'Сайты';

        $this->layout->content = \View::make('admin.sites.index', [
            'title' => $this->layout->title
        ]);
    }
    
    public function getVisitors()
    {
        $this->layout->title = 'Посетители';

        $this->layout->content = \View::make('admin.visitors.index', [
            'title' => $this->layout->title
        ]);
    }
    
    public function getBalance()
    {
        $this->layout->title = 'Движение средств';
        $this->layout->content = '';
    }
    
    public function getStatistics()
    {
        $this->layout->title = 'Статистика';
        $this->layout->content = '';
    }
    
    public function getSupport()
    {
        $this->layout->title = 'Техническая поддержка';
        
        $this->layout->content = \View::make('admin.support.index');
    }
    
    public function getRoles()
    {
        $this->layout->title = 'Управление группами';
        $this->layout->content = '';
    }
    
    public function getUsers()
    {
        $this->layout->title = 'Пользователи';
        $this->layout->content = '';
    }
}