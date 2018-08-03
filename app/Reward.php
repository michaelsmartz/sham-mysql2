<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Reward extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'description',
                  'rewarded_by',
                  'date_received'
              ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }


}