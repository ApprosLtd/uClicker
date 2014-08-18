<?php

namespace Admin;

class CollectionsController extends \Admin\BaseController
{
    
    protected $sources_list = [
        'categories' => ['model_name' => 'TicketCategory', 'table_name' => 'tickets_categories'],
        'priorities' => ['model_name' => 'TicketPriority', 'table_name' => 'tickets_priorities'],
        'statuses'   => ['model_name' => 'TicketStatus',   'table_name' => 'tickets_statuses'],
    ];

    protected function getSourceTableName($source_name)
    {
        if (!array_key_exists($source_name, $this->sources_list)) {
            return null;
        }
        
        return $this->sources_list[$source_name]['table_name'];
    }
    
    
    protected function getSourceModelName($source_name)
    {
        if (!array_key_exists($source_name, $this->sources_list)) {
            return null;
        }
        
        return $this->sources_list[$source_name]['model_name'];
    }
    
    
    public function getIndex()
    {
        $this->layout->title = 'Справочники';
        
        $source_name = \Input::get('source');
        
        if (!$source_name) {
            $this->layout->content = \View::make('admin.collections.index');
            return;
        }
        
        switch ($source_name) {
            case 'categories':
                $data = [
                    'title'  => 'Категории тикетов (тех. поддержка)',
                ];
                break;
            case 'priorities':
                $data = [
                    'title'  => 'Приоритеты тикетов (тех. поддержка)',
                ];
                break;
            case 'statuses':
                $data = [
                    'title'  => 'Статусы тикетов (тех. поддержка)',
                ];
                break;
            default:
                $this->layout->content = "Ресурс {$source_name} не найден";
                return;
        }
        
        $data['source']      = $this->getSourceTableName($source_name);
        $data['source_name'] = $source_name;


        $grid1 = new \Gridman([
            'id' => 'grid-collection',
            'is_ajax' => true,
            'source_name' => $source_name,
            'columns' => [
                [
                    'key'   => 'id',
                    'title' => '#'
                ],
                [
                    'key'   => 'title',
                    'title' => 'Наименование'
                ]
            ],
        ]);

        $grid2 = new \Gridman([
            'id' => 'grid-collection',
            'is_ajax' => true,
            'source_name' => 'priorities',
            'columns' => [
                [
                    'key'   => 'id',
                    'title' => '#'
                ],
                [
                    'key'   => 'title',
                    'title' => 'Наименование'
                ],
                [
                    'key'    => 'color',
                    'title'  => 'Цвет',
                    'widget' => 'color_view'
                ]
            ],
        ]);

        $data['grid'] = $grid1 . $grid2;
        
        $this->layout->content = \View::make('admin.collections.source', $data);
    }
    
    
    public function getEdit($source_name = null)
    {
        $show   = \Input::get('show');
        $modify = \Input::get('modify');
        $delete = \Input::get('delete');
        
        $source_model_name = $this->getSourceModelName($source_name);
        
        if (!$source_name) {
            $this->layout->content = 'Не указан ресурс';
            return;
        }
        
        $form = \DataForm::source($source_model_name::find($show));
        
        // Форма просмотра
        if ($show) {
            //
        }
        // Форма редактирования
        elseif ($modify) {
            //
        }
        // Процесс удаления
        elseif ($delete) {
            //
        }
        // Пустая форма для нового элемента
        else {
            //
        }
        
        
        //$form = DataForm::source(Article::find(1));

        $form->add('title','Title', 'text')->rule('required|min:5');
        $form->add('color','Color','colorpicker');

        $form->submit('Сохранить');
        
        $form->saved(function() use ($form)
        {
            $form->message("ok record saved");
            $form->link("/rapyd-demo/form","back to the form");
        });

        $this->layout->content = \View::make('widgets.grid.form', compact('form'));
    }


}
