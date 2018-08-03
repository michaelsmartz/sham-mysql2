<?php

namespace App\Widgets;

use App\Division;
use App\Support\Collection;
use Arrilot\Widgets\AbstractWidget;

class Divisions extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $temp = Division::orderBy('description','asc')->pluck('description','id');
        $divisions = (new Collection($temp))->toJsonTags();

        return view('widgets.divisions', [
            'config' => $this->config,
            'divisions' => $divisions
        ]);
    }
}
