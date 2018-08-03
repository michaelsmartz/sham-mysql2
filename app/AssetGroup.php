<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class AssetGroup extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'description',
                  'is_active'
              ];



}