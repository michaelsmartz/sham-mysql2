<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'time_group_id'
              ];

    public function timeGroup()
    {
        return $this->belongsTo('App\TimeGroup','time_group_id','id');
    }

    public function employees()
    {
        return $this->hasMany('App\Employee','team_id','id');
    }

    public function teamProducts()
    {
        return $this->hasMany('App\TeamProduct','team_id','id');
    }


}