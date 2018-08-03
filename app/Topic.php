<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'header',
                  'description',
                  'data'
              ];

    public function modules()
    {
        return $this->belongsToMany('App\Module');
    }


}