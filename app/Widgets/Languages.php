<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Language;
use App\Support\Collection;

class Languages extends AbstractWidget
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
        //
        $temp = Language::orderBy('description','asc')->pluck('description','id');
        $languages = (new Collection($temp))->toJsonTags();

        return view('widgets.languages', [
            'config' => $this->config,
            'languages' => $languages
        ]);
    }
}
