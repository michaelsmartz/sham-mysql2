<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class DisabilityCategory extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'is_system_predefined'
              ];

    public function disabilities()
    {
        return $this->hasMany('App\Disability','disability_category_id');
    }

}