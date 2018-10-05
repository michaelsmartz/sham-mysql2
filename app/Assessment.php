<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
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

    public function assessmentsAssessmentCategories()
    {
        return $this->belongsToMany(AssessmentCategory::class,'assessments_assessment_category','assessment_id','assessment_category_id');
    }

    public function evaluationResults()
    {
        return $this->hasMany('App\EvaluationResult','assessment_id','id');
    }

    public function evaluations()
    {
        return $this->hasMany('App\Evaluation','assessment_id','id');
    }


}