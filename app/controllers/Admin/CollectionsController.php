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

        $modal_body_template = 'common-template-1';
        $modal_title = '';

        switch ($source_name) {
            case 'categories':
                $data = [
                    'title'  => 'Категории тикетов (тех. поддержка)',
                ];
                $modal_title = 'Новая категория';
                break;
            case 'priorities':
                $data = [
                    'title'  => 'Приоритеты тикетов (тех. поддержка)',
                ];
                $modal_title = 'Новый приоритет';
                $modal_body_template = 'common-template-2';
                break;
            case 'statuses':
                $data = [
                    'title'  => 'Статусы тикетов (тех. поддержка)',
                ];
                $modal_title = 'Новый статус';
                break;
            default:
                $this->layout->content = "Ресурс {$source_name} не найден";
                return;
        }

        $data['source_name'] = $source_name;
        $data['modal_title'] = $modal_title;
        $data['modal_body_template'] = $modal_body_template;
        
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
