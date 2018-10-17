<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleAssessmentResponseDetail extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'module_assessment_id',
                  'module_id',
                  'module_question_id',
                  'module_assessment_response_id',
                  'content',
                  'points',
                  'sequence'
              ];

    public function moduleAssessment()
    {
        return $this->belongsTo('App\ModuleAssessment','module_assessment_id');
    }

    public function module()
    {
        return $this->belongsTo('App\Module','module_id');
    }

    public function moduleQuestion()
    {
        return $this->belongsTo('App\ModuleQuestion','module_question_id');
    }

    public function moduleAssessmentResponse()
    {
        return $this->belongsTo('App\ModuleAssessmentResponse','module_assessment_response_id');
    }


}