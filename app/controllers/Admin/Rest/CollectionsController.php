<?php namespace Admin\Rest;

class CollectionsController extends \BaseController {

    protected $models_collection = [
        'categories' => 'TicketCategory',
        'priorities' => 'TicketPriority',
        'statuses'   => 'TicketStatus',
    ];

    protected function getModelNameByAlias($model_alias)
    {
        if (!array_key_exists($model_alias, $this->models_collection)) {
            return null;
        }

        return '\\' . $this->models_collection[$model_alias];
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $model_alias = \Input::get('model');
        $limit  = \Input::get('limit', 20);
		$offset = \Input::get('offset', 0);

        $model_alias = 'categories';

        $model_name = $this->getModelNameByAlias($model_alias);

        if (!$model_name) {
            return ['error' => 'Model not found by alias'];
        }
        
        $rows = $model_name::take($limit)->skip($offset)->get();
        
        $output = [
            'data'   => $rows->toArray(),
            'total_count'  => $rows->count(),
            'limit'  => $limit,
            'offset' => $offset,
            'success' => true
        ];
        
        return $output;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $model_alias = \Input::get('model');
        $fields = \Input::get('fields');

        $model_name = $this->getModelNameByAlias($model_alias);

        if (!$model_name) {
            return ['error' => 'Model not found by alias'];
        }

        $model_obj = new $model_name($fields);
        $model_obj->save();

        return $model_obj->toArray();

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
