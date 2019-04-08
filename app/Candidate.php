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
        return $this->belongsTo('App\JobTitle','job_title_id','id')->select(['job_titles.id','job_titles.description']);
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

    public function status()
    {
        return $this->belongsToMany(Recruitment::class, 'candidate_recruitment')
                    ->select(['candidate_id','status']);
    }

    public function recruitment_status()
    {
        return $this->belongsToMany(Recruitment::class, 'recruitment_status')
            ->select(['candidate_id','comment']);
    }

    public function interviews()
    {
        return $this->belongsToMany(Interview::class, 'candidate_interview_recruitment','candidate_id','interview_id')->withPivot('id','reasons','schedule_at','results','location','status');
    }

    public function contracts()
    {
        return $this->belongsToMany(Contract::class, 'contract_recruitment')
                    ->select(['candidate_id','contract_id','start_date','signed_on','comments']);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_recruitment')
                    ->select(['candidate_id','offer_id','signed_on','comments']);
    }

    public function scopeCandidatesList($query)
    {
        $query->leftJoin('candidate_previous_employments','candidate_previous_employments.candidate_id','=','candidates.id')
              ->leftJoin('job_titles','job_titles.id','=','candidates.job_title_id')
              ->leftJoin('candidate_qualifications','candidate_qualifications.candidate_id','=','candidates.id')
              ->select('candidates.id','candidates.first_name','candidates.surname',
                       'job_titles.description as job_title','candidate_previous_employments.previous_employer',
                       'candidate_previous_employments.position','candidate_previous_employments.start_date',
                       'candidate_previous_employments.end_date')
              ;
    }

}
