<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;
use San4io\EloquentFilter\Filters\LikeFilter;

class Candidate extends Model
{
    use Mediable;
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'candidates';

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
                  'first_name',
                  'gender_id',
                  'title_id',
                  'marital_status_id',
                  'surname',
                  'name',
                  'email',
                  'home_address',
                  'id_number',
                  'job_title_id',
                  'date_available',
                  'salary_expectation',
                  'phone',
                  'preferred_notification_id',
                  'birth_date',
                  'overview',
                  'cover',
                  'picture',
                  'addr_line_1',
                  'addr_line_2',
                  'addr_line_3',
                  'addr_line_4',
                  'city',
                  'province',
                  'zip',
              ];

    protected $searchable = [
        'first_name',
        'surname',
        'email',
        'phone',
        'jobTitle:job_title_id'
    ];

    protected $filterable = [
        'first_name' => LikeFilter::class,
        'surname' => LikeFilter::class,
        'email' => LikeFilter::class,
        'phone' => LikeFilter::class,
        'jobTitle:job_title_id' => LikeFilter::class
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

    public static function boot()
    {
        parent::boot();
    
        static::addGlobalScope('candidateName', function (Builder $builder) {
			if(is_null($builder->getQuery()->columns)){
				$builder->addSelect('*');
			}
            $builder->addSelect(DB::raw('CONCAT(first_name, " ", surname) AS name'));
        });
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class,'candidate_disability','candidate_id','disability_id');
        //return $this->belongsToMany(Disability::class);
    }

    public function title()
    {
        return $this->belongsTo('App\Title','title_id','id');
    }

    public function maritalstatus()
    {
        return $this->belongsTo('App\Maritalstatus','marital_status_id','id');
    }

    public function jobTitle()
    {
        return $this->belongsTo('App\JobTitle','job_title_id','id');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender','gender_id','id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function qualifications()
    {
        return $this->hasMany('App\CandidateQualification','candidate_id','id');
    }

    public function previousEmployments()
    {
        return $this->hasMany('App\CandidatePreviousEmployment','candidate_id','id');
    }

    public function recruitments()
    {
        return $this->belongsToMany('App\Recruitment');
    }
}
