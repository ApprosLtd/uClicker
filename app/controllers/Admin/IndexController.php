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

        $grid = new \Gridman([
            'id' => 'grid-collection',
            'is_ajax' => true,
            'source_name' => 'merchants',
            'columns' => [
                [
                    'key'   => 'id',
                    'title' => '#'
                ],
                [
                    'key'   => 'email',
                    'title' => 'Email'
                ]
            ],
        ]);

        $this->layout->content = \View::make('admin.gridman.index', array(
            'title' => $this->layout->title,
            'grid'  => $grid
        ));
    }
    
    public function getSites()
    {
        $this->layout->title = 'Сайты';

        $grid = new \Gridman([
            'id' => 'grid-collection',
            'is_ajax' => true,
            'source_name' => 'sites',
            'columns' => [
                [
                    'key'   => 'id',
                    'title' => '#'
                ],
                [
                    'key'   => 'domain',
                    'title' => 'Домен'
                ],
                [
                    'key'   => 'owner',
                    'title' => 'Владалец'
                ],
                [
                    'key'   => 'created_at',
                    'title' => 'Добавлен'
                ]
            ],
        ]);

        $this->layout->content = \View::make('admin.gridman.index', array(
            'title' => $this->layout->title,
            'grid'  => $grid
        ));
    }
    
    public function getVisitors()
    {
        $this->layout->title = 'Посетители';

        $grid = new \Gridman([
            'id' => 'grid-collection',
            'is_ajax' => true,
            'source_name' => 'visitors',
            'columns' => [
                [
                    'key'   => 'id',
                    'title' => '#'
                ],
                [
                    'key'   => 'first_name',
                    'title' => 'Имя'
                ],
                [
                    'key'   => 'last_name',
                    'title' => 'Фамилия'
                ],
                [
                    'key'   => 'vendor',
                    'title' => 'Соц. сеть'
                ],
                [
                    'key'   => 'uid',
                    'title' => 'Соц. ИД'
                ],
                [
                    'key'   => 'sex',
                    'title' => 'Пол'
                ],
                [
                    'key'   => 'created_at',
                    'title' => 'Добавлен'
                ],
                [
                    'key'   => 'blocked',
                    'title' => 'Статус'
                ]
            ],
        ]);

        $this->layout->content = \View::make('admin.gridman.index', array(
            'title' => $this->layout->title,
            'grid'  => $grid
        ));
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