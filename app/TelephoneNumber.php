<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class TelephoneNumber extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'tel_number',
                  'telephone_number_type_id'
              ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function telephoneNumberType()
    {
        return $this->belongsTo('App\TelephoneNumberType','telephone_number_type_id');
    }


}