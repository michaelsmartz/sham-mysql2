<?php

namespace App\LeaveRules;

class Rule110 extends LeaveBaseClass
{
    public $ret;
    public $retCollection;

    protected $carbonProbationEndDate;

    public function __construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd)
    {

        parent::__construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd);

        $this->retCollection = [];
    }

    public static function applyEligibilityFilter($query, $absenceTypeId, $dateValue)
    {
        $query->where('absence_type_id', '=', $absenceTypeId)
            ->where('end_date', '>=', $dateValue);

        return $query;
    }

    public function shouldAddNew()
    {
        $ret = false;

        return $ret;
    }

}
