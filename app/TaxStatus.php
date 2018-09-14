<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class TaxStatus extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'Description',
                  'is_system_predefined'
              ];

    public $searchable = ['Description'];

    public function employees()
    {
        return $this->hasMany('App\Employee');
    }


}