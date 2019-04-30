<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use San4io\EloquentFilter\Filters\LikeFilter;
use San4io\EloquentFilter\Filters\WhereFilter;

class AbsenceType extends Model
{

    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'accrue_period',
                  'amount_earns',
                  'description',
                  'duration_unit',
                  'eligibility_ends',
                  'eligilibity_begins'
              ];

    protected $filterable = [
                'description' => LikeFilter::class,
                'eligilibity_begins' => LikeFilter::class,
                'eligibility_ends' => LikeFilter::class
            ];

    public function eligibilityEmployees()
    {
        return $this->belongsToMany('App\Employee','eligibility_employee');
    }

    public function absenceTypeJobTitles()
    {
        return $this->belongsToMany('App\JobTitle','absence_type_job_title');
    }

    public function absenceTypeEmployees()
    {
        return $this->belongsToMany('App\Employee','absence_type_employee');
    }


}