<?php

namespace Admin\Rest;


class MerchantsController extends \Admin\BaseController {

    public function index()
    {
        $limit  = \Input::get('limit', 20);
        $offset = \Input::get('offset', 0);

        $rows = \Merchant::take($limit)->skip($offset)->get();

        $output = [
            'data'   => $rows->toArray(),
            'total_count'  => $rows->count(),
            'limit'  => $limit,
            'offset' => $offset,
            'success' => true
        ];

        return $output;
    }
} 