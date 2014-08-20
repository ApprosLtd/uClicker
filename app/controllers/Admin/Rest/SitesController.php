<?php namespace Admin\Rest;

class SitesController extends \Admin\BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index()
    {
        $limit  = \Input::get('limit', 20);
        $offset = \Input::get('offset', 0);

        $rows = \Site::take($limit)->skip($offset)->get();

        $data_rows = [];
        if ($rows) {
            foreach ($rows as $row) {
                //user_email

                $row->user_email = $row->user->email;

                $data_rows[] = $row;
            }
        }

        $output = [
            'data'    => $data_rows,
            'total_count'  => $rows->count(),
            'limit'   => $limit,
            'offset'  => $offset,
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
