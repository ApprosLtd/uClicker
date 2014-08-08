<?php

namespace Dashboard;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class SiteController extends \BaseController {

    public function anyGet()
    {
        $site_id = Input::get('site_id');

        $site = $this->user()->sites()->find($site_id);

        return Response::json(array(
            'site_id' => $site->id,
            'domain'  => $site->domain,
            'comment' => $site->comment,
        ));
    }

    /**
     * Сохранение сайта
     * @return \Illuminate\Http\JsonResponse
     */
    public function anySave()
    {
        $site_id = Input::get('site_id');

        $domain  = Input::get('domain');
        $domain  = strtolower($domain);

        $comment = Input::get('comment');

        if ($site_id > 0) {
            $site = $this->user()->sites()->find($site_id);
            $site->domain  = $domain;
            $site->comment = $comment;
            $site->save();

        } else {
            $site = new \Site();
            $site->domain  = $domain;
            $site->comment = $comment;
            $this->user()->sites()->save($site);
        }

        return Response::json(array(
            'site_id' => $site->id
        ));
    }


    /**
     * Блокировка сайта
     */
    public function anyBlocking()
    {
        $site_id  = Input::get('site_id');

        $site_obj = $this->user()->blockingSites($site_id);
    }


    /**
     * Разблокировка сайта
     */
    public function anyUnblocking()
    {
        $site_id  = Input::get('site_id');

        $site_obj = $this->user()->unblockingSites($site_id);
    }


    /**
     * Удаление сайта
     */
    public function anyRemove()
    {
        $site_id  = Input::get('site_id');

        $site_obj = $this->user()->removeSites($site_id);
    }

} 