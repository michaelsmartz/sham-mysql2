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

    public $searchable = ['name','description'];

    public function assessmentAssessmentCategory()
    {
        return $this->belongsToMany(AssessmentCategory::class,'assessments_assessment_category','assessment_id','assessment_category_id')
            ->withPivot('is_active')->where('assessments_assessment_category.is_active',1);
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