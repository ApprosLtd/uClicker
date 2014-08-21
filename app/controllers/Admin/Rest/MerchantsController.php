<?php

namespace Admin\Rest;


class MerchantsController extends \Admin\BaseController {

    public function index()
    {
        $limit  = \Input::get('limit', 20);
        $offset = \Input::get('offset', 0);

        $rows = \Merchant::get();

        $output_rows = [];
        if ($rows) {
            foreach ($rows as $row) {
                $output_rows[] = [
                    'id'         => $row->id,
                    'email'      => $row->email,
                    'balance'    => $row->balance,
                    'created_at' => $row->created_at,
                ];
            }
        }

        $output = [
            'data'   => $output_rows,
            'total_count'  => $rows->count(),
            'limit'  => $limit,
            'offset' => $offset,
            'success' => true
        ];

        return $output;
    }
} 