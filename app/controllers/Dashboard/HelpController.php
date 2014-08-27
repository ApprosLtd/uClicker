<?php

namespace Dashboard;

class HelpController extends \BaseController {

    public $layout = 'dashboard.layout';

	public function getMarkdown($markdown = 'introduction-get-started')
	{
        $this->layout->title = '';

        $this->layout->current_page = 'help';

        $this->layout->content = \View::make('dashboard.help.index', [
            'markdown' => \Markdown::make($markdown)
        ]);
	}

}
