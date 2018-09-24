<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class TimeGroup extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'start',
                  'end'
              ];

    public $searchable = ['name'];

    protected $table = 'time_groups';

}