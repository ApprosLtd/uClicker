<?php

namespace Admin\Rest;

class TicketsController extends \Admin\BaseRestController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $rows_arr = \Ticket::limit(20)->orderBy('created_at', 'DESC')->get();
        
        $output_arr = [];
        if ($rows_arr) {
            foreach ($rows_arr as $row_obj) {
                $row_mix = [
                    'id'    => $row_obj->id,
                    'title' => $row_obj->title,
                    'created_at' => date('d.m.Y в H:i', strtotime($row_obj->created_at)),
                    'category_title' => '',
                    'priority_title' => '',
                    'priority_color' => '',
                    'status'   => 'Принято',
                ];
                
                $category = $row_obj->category;
                if ($category) {
                    $row_mix['category_title'] = $row_obj->category->title;
                }
                $priority = $row_obj->priority;
                if ($priority) {
                    $row_mix['priority_title'] = $row_obj->priority->title;
                    $row_mix['priority_color'] = $row_obj->priority->color;
                }
                
                $output_arr[] = $row_mix;
            }
        }
        
		return ['data' => $output_arr];
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
		//
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
