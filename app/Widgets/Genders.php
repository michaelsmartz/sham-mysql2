<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Gender;
use App\Support\Collection;

class Genders extends AbstractWidget
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
        $temp = Gender::pluck('description','id');
        $genders = (new Collection($temp))->toJsonTags();

        return view('widgets.genders', [
            'config' => $this->config,
            'genders' => $genders
        ]);
    }
}
