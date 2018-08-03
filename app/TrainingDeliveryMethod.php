<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingDeliveryMethod extends Model
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



}