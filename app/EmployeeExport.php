<?php

namespace App;

use Maatwebsite\Excel\Concerns\FromArray;

class EmployeeExport implements FromArray
{
    protected $employees;

    public function __construct()
    {
        //$this->$employees = $employees;
    }

    public function employees($val)
    {
        $this->employees = $val;
    }

    public function array(): array
    {
        return $this->employees;
    }

}