<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use San4io\EloquentFilter\Filters\LikeFilter;

class Recruitment extends Model
{
    
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recruitments';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id',
        'employee_status_id',
        'qualification_id',
        'job_title',
        'field_of_study',
        'description',
        'year_experience',
        'start_date',
        'end_date',
        'min_salary',
        'max_salary',
        'recruitment_type_id'
    ];

    protected $searchable = [
        'job_title',
        'qualification_recruitment:description',
        'year_experience',
        'field_of_study',
        'start_date'
    ];

    protected $filterable = [
        'job_title' => LikeFilter::class,
        'qualification_recruitment:description' => LikeFilter::class,
        'year_experience' => LikeFilter::class,
        'field_of_study' => LikeFilter::class,
        'start_date' => LikeFilter::class
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
               'deleted_at'
           ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    

    /**
     * Set the start_date.
     *
     * @param  string  $value
     * @return void
     */
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get start_date in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getStartDateAttribute($value)
    {
        return date('j/n/Y', strtotime($value));
    }

    /**
     * Get deleted_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDeletedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    public function qualification()
    {
        return $this->belongsTo('App\QualificationRecruitment','qualification_id','id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department','department_id','id');
    }

    public function employeeStatus()
    {
        return $this->belongsTo('App\EmployeeStatus','employee_status_id','id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function interviewTypes()
    {
        return $this->belongsToMany(Interview::class);
    }

    public function qualification_recruitment()
    {
        return $this->belongsTo('App\QualificationRecruitment','qualification_id');
    }

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class);
    }
}
