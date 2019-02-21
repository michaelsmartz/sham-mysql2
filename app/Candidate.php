<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

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
                  'email',
                  'home_address',
                  'id_number',
                  'position_applying_for',
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
     * Set the date_available.
     *
     * @param  string  $value
     * @return void
     */
    public function setDateAvailableAttribute($value)
    {
        $this->attributes['date_available'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get date_available in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDateAvailableAttribute($value)
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

}
