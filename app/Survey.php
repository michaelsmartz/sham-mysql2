<?php

namespace App;


class Survey extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'surveys';

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
                  'title',
                  'date_start',
                  'EndDate',
                  'author_sham_user_id',
                  'form_id',
                  'final'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    
    /**
     * Get the users for this model.
     */
    public function users()
    {
        return $this->belongsTo('App\User','author_sham_user_id','id');
    }

    /**
     * Set the date_start.
     *
     * @param  string  $value
     * @return void
     */
    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Set the EndDate.
     *
     * @param  string  $value
     * @return void
     */
    public function setEndDateAttribute($value)
    {
        $this->attributes['EndDate'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get date_start in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDateStartAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    /**
     * Get EndDate in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getEndDateAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

}
