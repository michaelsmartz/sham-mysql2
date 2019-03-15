<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'content'
              ];



}