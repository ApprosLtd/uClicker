<?php
  
namespace Serovvitaly\Gridman;

class GridmanColumn
{
    public $title = '';
    
    public $key = '';
    
    public function __construct(array $params)
    {
        $this->title = $params['title'];
        $this->key   = $params['key'];
    }
}
