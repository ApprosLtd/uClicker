<?php

namespace Widget;

class Grid {

    public static function render($data)
    {
        return \View::make('widgets.grid.wrapper', $data);
    }

} 