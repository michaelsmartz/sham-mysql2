<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class CandidatePreviousEmployment extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'candidate_id',
                  'previous_employer',
                  'position',
                  'salary',
                  'reason_leaving',
                  'start_date',
                  'end_date',
              ];

    public function candidate()
    {
        return $this->belongsTo('App\Candidate','candidate_id','id');
    }
}