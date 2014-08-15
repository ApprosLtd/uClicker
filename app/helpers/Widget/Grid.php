<?php

namespace Widget;

class Grid {

    public static function render($data)
    {
        return \View::make('widgets.grid.wrapper', $data);
    }

    public static function controls($data)
    {
        return \View::make('widgets.grid.controls', $data);
    }

} 