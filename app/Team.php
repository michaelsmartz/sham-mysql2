<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    
    //use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'timegroup_id',
                  'is_active'
              ];

    /**
     * Get the timegroup for this model.
     */
    public function timegroup()
    {
        return $this->belongsTo('App\Timegroup');
    }


}