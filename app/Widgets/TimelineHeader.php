<?php

namespace App\Widgets;

use App\Employee;
use Illuminate\Support\Facades\Route;
use Arrilot\Widgets\AbstractWidget;

class TimelineHeader extends AbstractWidget
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

        $id = $this->config['employee'];
        $employee = Employee::with(['jobTitle',
                        'department',
                        'branch',
                        'division',
                        'team'])
                    ->where('employees.id',$id)->get()->first();

        return view('widgets.timeline_header', [
            'config' => $this->config,
            'employee' => $employee
        ]);
    }
}
