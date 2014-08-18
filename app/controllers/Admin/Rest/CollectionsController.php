<?php namespace Admin\Rest;

class CollectionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $model  = \Input::get('model');
        $limit  = \Input::get('limit');
		$offset = \Input::get('offset');
        
        $models_collection = [
            'categories' => 'TicketCategory',
            'priorities' => 'TicketPriority',
            'statuses'   => 'TicketStatus',
        ];
        
        if (!array_key_exists($model, $models_collection)) {
            return ['error' => ''];
        }
        
        $model_name = '\\' . $models_collection[$model];
        
        $rows = $model_name::get();
        
        $output = [
            'data'   => $rows->toArray(),
            'total'  => $rows->count(),
            'limit'  => $limit,
            'offset' => $offset,
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
        return [2,3];
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
