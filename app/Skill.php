<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'level',
                  'is_system_predefined'
              ];

    public function employees()
    {
        return $this->belongsToMany('App\Employee');
    }


}