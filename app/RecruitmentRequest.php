<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class RecruitmentRequest extends Model
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
                  'job_title',
                  'position',
                  'description',
                  'year_experience',
                  'field_of_study',
                  'start_date',
                  'min_salary',
                  'max_salary'
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

    public function interviews()
    {
        return $this->hasMany('App\Interviews','recruitment_id','id');
    }

}
