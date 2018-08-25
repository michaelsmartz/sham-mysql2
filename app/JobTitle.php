<?php

namespace App;


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


}