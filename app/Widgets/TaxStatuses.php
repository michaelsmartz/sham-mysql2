<?php

namespace App\Widgets;

use App\TaxStatus;
use App\Support\Collection;
use Arrilot\Widgets\AbstractWidget;

class TaxStatuses extends AbstractWidget
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
        $temp = TaxStatus::orderBy('description','asc')->pluck('description','id');
        $taxstatuses = (new Collection($temp))->toJsonTags();

        return view('widgets.divisions', [
            'config' => $this->config,
            'taxstatuses' => $taxstatuses
        ]);
    }
}
