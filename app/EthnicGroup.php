<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class EthnicGroup extends Model
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

    public function employees()
    {
        return $this->hasMany('App\Employee','ethnic_group_id','id');
    }


}