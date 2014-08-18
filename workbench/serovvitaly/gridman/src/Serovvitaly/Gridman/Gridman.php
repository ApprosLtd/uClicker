<?php
  
namespace Serovvitaly\Gridman;

class Gridman
{
    static $first = true;
    
    protected $wrapper_view_path = 'gridman::wrappers.table';
    
    protected $id    = null;
    
    protected $model = null;

    protected $source_name = null;

    protected $is_ajax = true;
    
    protected $columns = [];
    
    public function __construct(array $params)
    {
        foreach ($params['columns'] as $column_params) {
            $this->columns[] = new GridmanColumn($column_params);
        }
        
        $this->id = $params['id'];

        $this->source_name = $params['source_name'];
    }
    
    public static function make(array $params)
    {
        return new self($params);
    }
    
    public function __toString()
    {
        return $this->render();
    }
    
    public function render()
    {
        $data = [];
        
        $data['columns'] = $this->prepareColumns();
        
        $data['id'] = $this->id;
        
        $data['attach_jquery_plugin'] = static::$first;

        $data['source_name'] = $this->source_name;

        try{
            $view = \View::make($this->wrapper_view_path, $data)->render();
            
            static::$first = false;
            
            return $view;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    /**
    * Подготовка колонок для вывода
    * 
    */
    protected function prepareColumns()
    {
        return $this->columns;
    }


    public static function getModelNameBySourceName($source_name)
    {
        // TODO: перенести конфиг в /app/config
        return \Config::get('gridman::sources.' . $source_name . '.model_name');
    }
    
    
    /**
    * Определяет модель
    * 
    * @param mixed $model_name
    */
    public function setModel($model_name)
    {
        $this->model = new $model_name;
    }
    
    
    /**
    * Устанавливает шаблон обертки
    * 
    * @param mixed $wrapper_view_path
    */
    public function setWrapper($wrapper_view_path)
    {
        $this->wrapper_view_path = $wrapper_view_path;
    }
    
    
    public function setAjax($is)
    {
        if ($is) {
            $this->is_ajax = true;
        } else {
            $this->is_ajax = false;
        }
        
        return $this;
    }
}