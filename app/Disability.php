<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Disability extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'disability_category_id',
                  'is_system_predefined'
              ];

    public function disabilityCategory()
    {
        return $this->belongsTo('App\DisabilityCategory','disability_category_id');
    }


}