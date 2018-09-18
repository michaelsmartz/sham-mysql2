<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Timegroup extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'start',
                  'end'
              ];

    public $searchable = ['description'];

    protected $table = 'time_groups';

}