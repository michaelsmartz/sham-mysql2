<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTrainingSession extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'course_id',
                  'training_delivery_method_id',
                  'is_final'
              ];

    public function course()
    {
        return $this->belongsTo('App\Course','course_id');
    }

    public function trainingDeliveryMethod()
    {
        return $this->belongsTo('App\TrainingDeliveryMethod','training_delivery_method_id');
    }


}