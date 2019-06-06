<?php
namespace App\LeaveRules;

interface ILeaveRules
{
    public function GetEligibilityValue();

    public function getQuery();
}