<?php

class CrudModel extends Eloquent
{
    /**
    * Подготовка параметров 
    * @param mixed $params
    */
    protected static function prepareParams(array $params)
    {
        return array_merge(array(
            'wrapper_view_path' => 'widgets.grid.wrapper',
            'item_view_path'    => 'widgets.grid.item',
        ), $params);
    }
    
    
    /**
    * Выводит таблицу 
    * @param mixed $params
    */
    public static function renderGrid(array $params = array())
    {
        $params = self::prepareParams($params);
        
        print_r($params);
    }
}