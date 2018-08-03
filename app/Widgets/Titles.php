<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Title;
use App\Support\Collection;

class Titles extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    public function placeholder()
    {
        return 'Loading...';
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //
        $temp = Title::pluck('description','id');
        $titles = (new Collection($temp))->toJsonTags();
        
        return view('widgets.titles', [
            'config' => $this->config,
            'titles' => $titles
        ]);
    }
}
