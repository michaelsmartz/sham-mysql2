<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class DisciplinaryAction extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'violation_id',
                  'employee_statement',
                  'employer_statement',
                  'decision',
                  'updated_by',
                  'date_issued',
                  'date_expires',
                  'disciplinary_decision_id'
              ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function violation()
    {
        return $this->belongsTo('App\Violation','violation_id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User','updated_by');
    }

    public function disciplinaryDecision()
    {
        return $this->belongsTo('App\DisciplinaryDecision','disciplinary_decision_id');
    }


}