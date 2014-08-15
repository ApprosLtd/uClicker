<?php

namespace Dashboard;

class SupportController extends \BaseController
{
    public $layout = 'dashboard.layout';
    
    public function getIndex()
    {
        $this->layout->title = 'Поддержка';
        
        $tickets_count = $this->user()->tickets()->count();
        
        $this->layout->content = \View::make('dashboard.support.index', array(
            'is_empty' => ($tickets_count > 0) ? true : false
        ));
    }
    
    
    public function postAddTicket()
    {
        $title    = \Input::get('title');
        $priority = \Input::get('priority');
        $category = \Input::get('category');
        $content  = \Input::get('content');
        
        $ticket_obj = new \Ticket();
        
        $ticket_obj->title       = $title;
        $ticket_obj->priority_id = $priority;
        $ticket_obj->category_id = $category;
        $ticket_obj->content     = $content;
        
        $this->user()->tickets()->save($ticket_obj);
        
        return \Response::json(array());
    }
} 