<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

class Evaluation extends Model
{
    use Mediable;
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

    public function useremployee()
    {
        return $this->belongsTo('App\Employee','user_employee_id','id');
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

    public function assessors()
    {
        return $this->belongsToMany(Employee::class,'employee_evaluation','evaluation_id','employee_id')->withPivot('is_completed','summary','comments','id');
    }

    public function evaluationResults()
    {
        return $this->belongsToMany(Employee::class,'evaluation_results','evaluation_id','assessor_employee_id')
            ->withPivot('assessment_id','assessment_category_id','category_question_id','content','points','is_active');
    }

}