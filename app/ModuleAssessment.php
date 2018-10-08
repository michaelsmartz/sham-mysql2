<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleAssessment extends Model
{
    
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'module_id',
                  'assessment_type_id',
                  'description',
                  'data',
                  'pass_mark',
                  'trainer_id'
              ];

    public function module()
    {
        return $this->belongsTo('App\Module','module_id','id');
    }

    public function assessmentType()
    {
        return $this->belongsTo('App\AssessmentType','assessment_type_id','id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee','trainer_id','id');
    }

    public function questions()
    {
        return $this->hasMany('App\ModuleAssessmentQuestion','module_assessment_id')->where('is_active',1);
    }

}