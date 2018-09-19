<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobTitle extends Model
{
    
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'is_manager',
                  'is_system_predefined'
              ];

    public $searchable = ['description'];

    public function scopeManagerialJobs($query)
    {
        $this->withManagerialJobs($query);
    }

    protected function withManagerialJobs($query)
    {
        $query->where( 'is_manager', '=', 1);
    }

    public function employees()
    {
        return $this->hasMany('App\Employee', 'job_title_id', 'id')->select('job_title_id','id','first_name','surname');
    }

    public function historyjobtitles()
    {
        return $this->hasMany('App\Historyjobtitle','JobTitleId','id');
    }

    public function temporaryjob()
    {
        return $this->hasOne('App\Temporaryjob','JobTitleId','id');
    }

    public static function jobReportingLines()
    {
        $temp = static::
                select([DB::raw('DISTINCT job_titles.id'), 'description', 
                        DB::raw('(case when job_titles.is_manager=1 then employees.id else NULL end) AS employee_id'),
                        DB::raw("(case when job_titles.is_manager=1 then concat(employees.first_name,' ',employees.surname) else NULL end) AS full_name")
                ])
                ->leftJoin('employees', 'job_titles.id', '=', 'employees.job_title_id')
                ->whereNull('employees.deleted_at')
                ->get();
                
        return $temp;
    }


}