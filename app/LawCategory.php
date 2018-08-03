<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class LawCategory extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'is_active'
              ];



}