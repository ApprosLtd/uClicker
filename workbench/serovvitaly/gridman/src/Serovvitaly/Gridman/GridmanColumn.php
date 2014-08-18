<?php
  
namespace Serovvitaly\Gridman;

class GridmanColumn
{
    public $key    = '';
    public $title  = '';
    public $widget = null;

    public function __construct(array $params)
    {
        $this->key    = $params['key'];
        $this->title  = $params['title'];
        $this->widget = isset($params['widget']) ? $params['widget'] : null;

    }
}
