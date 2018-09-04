<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

class Assessment extends Model
{
    use Mediable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                'name',
                'description',
                'passmark_percentage'
    ];

}