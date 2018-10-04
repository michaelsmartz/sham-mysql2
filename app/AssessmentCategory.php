<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentCategory extends Model
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
                  'passmark_percentage'
              ];

    public $searchable = [];

    public function assessmentCategoryCategoryQuestions()
    {
        return $this->hasMany('App\AssessmentCategoryCategoryQuestion','assessmentcategory_id','id');
    }

    public function assessmentsAssessmentCategories()
    {
        return $this->hasMany('App\AssessmentsAssessmentCategory','assessmentcategory_id','id');
    }

    public function evaluationResults()
    {
        return $this->hasMany('App\EvaluationResult','assessmentcategory_id','id');
    }


}