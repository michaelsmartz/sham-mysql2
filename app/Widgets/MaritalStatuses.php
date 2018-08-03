<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\MaritalStatus;
use App\Support\Collection;

class MaritalStatuses extends AbstractWidget
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
        $temp = MaritalStatus::pluck('description','id');
        $maritalstatuses = (new Collection($temp))->toJsonTags();

        return view('widgets.marital_statuses', [
            'config' => $this->config,
            'maritalstatuses' => $maritalstatuses
        ]);
    }
}
