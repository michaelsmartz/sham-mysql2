<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'assessment_id',
                  'user_employee_id',
                  'department_id',
                  'reference_no',
                  'reference_source',
                  'productcategory_id',
                  'language_id',
                  'feedback_date',
                  'qa_sample',
                  'comments',
                  'evaluation_status_id',
                  'createdby_employee_id',
                  'original_filename',
                  'is_usecontent',
                  'url_path'
              ];

    public $searchable = [];

    public function assessment()
    {
        return $this->belongsTo('App\Assessment','assessment_id','id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee','createdby_employee_id','id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department','department_id','id');
    }

    public function productCategory()
    {
        return $this->belongsTo('App\ProductCategory','productcategory_id','id');
    }

    public function language()
    {
        return $this->belongsTo('App\Language','language_id','id');
    }

    public function evaluationStatus()
    {
        return $this->belongsTo('App\EvaluationStatus','evaluation_status_id','id');
    }

    public function evaluationAssessors()
    {
        return $this->hasMany('App\EvaluationAssessor','evaluation_id','id');
    }

    public function evaluationResults()
    {
        return $this->hasMany('App\EvaluationResult','evaluation_id','id');
    }


}