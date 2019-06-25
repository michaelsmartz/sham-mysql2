<?php

namespace App\Observers;

use App\AbsenceType;

/**
 * AbsenceType observer
 */
class AbsenceTypeObserver
{
    
    /**
     * @param AbsenceType $absenceType
     */
    public function deleting(AbsenceType $absenceType)
    {

        $absenceType->load(['eligibilityEmployees','jobTitles','absenceTypeEmployees']);
        
        $eligibilities = $absenceType->eligibilityEmployees();
        $jobTitles = $absenceType->jobTitles();
        $absenceTypeEmployees = $absenceType->absenceTypeEmployees();

        $absenceType->eligibilityEmployees()->sync([]);
        $absenceType->jobTitles()->sync([]);
        $absenceType->absenceTypeEmployees()->sync([]);

    }
}