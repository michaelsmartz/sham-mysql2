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
                  'eligibility_begins'
              ];

    public $searchable = [ 'accrue_period',
                            'amount_earns',
                            'description',
                            'duration_unit',
                            'eligibility_ends',
                            'eligibility_begins'
    ];

    protected $filterable = [
                'description' => LikeFilter::class,
                'eligibility_begins' => LikeFilter::class,
                'eligibility_ends' => LikeFilter::class,
                'duration_unit' => WhereFilter::class,
            ];

    public function eligibilityEmployees()
    {
        return $this->belongsToMany('App\Employee','eligibility_employee')->withPivot('id','start_date','end_date','total','taken','is_manually_adjusted');
    }

    public function jobTitles()
    {
        return $this->belongsToMany('App\JobTitle','absence_type_job_title');
    }

    public function absenceTypeEmployees()
    {
        return $this->belongsToMany('App\Employee','absence_type_employee');
    }


}