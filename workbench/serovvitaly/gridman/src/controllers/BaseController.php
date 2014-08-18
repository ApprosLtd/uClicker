<?php

namespace Serovvitaly\Gridman\Controllers;

use Serovvitaly\Gridman\Gridman;

class BaseController extends \Controller {

    public function index()
    {
        $response = [];

        $source = \Input::get('source');

        return $response;
    }

    public function store()
    {
        $response = [];

        $source = \Input::get('source');
        $offset = \Input::get('offset');
        $limit  = \Input::get('limit');

        $model_name = \Gridman::getModelNameBySourceName($source);

        if (!$model_name) {
            return ['error' => 'Source not found in config'];
        }

        $model_name = '\\' . $model_name;

        $model_obj_arr = $model_name::take($limit)->skip($offset)->get();
        $response['data']  = $model_obj_arr->toArray();

        $response['total'] = $model_name::count();

        return $response;
    }

    public function show($id)
    {
        //
    }

} 