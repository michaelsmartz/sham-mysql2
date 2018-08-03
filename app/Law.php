<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Law extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'mainHeading',
                  'subHeading',
                  'country_id',
                  'lawcategory_id',
                  'is_public',
                  'expires_on',
                  'content',
                  'is_active'
              ];

    /**
     * Get the country for this model.
     */
    public function country()
    {
        return $this->belongsTo('App\Country','country_id');
    }

    /**
     * Get the lawcategory for this model.
     */
    public function lawCategory()
    {
        return $this->belongsTo('App\LawCategory','lawcategory_id');
    }


}