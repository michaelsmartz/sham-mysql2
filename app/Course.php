<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use San4io\EloquentFilter\Filters\LikeFilter;
use San4io\EloquentFilter\Filters\WhereFilter;

class Course extends Model
{

    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'is_public',
        'overview',
        'objectives',
        'passmark_percentage',
    ];

    public $searchable = ['description', 'overview', 'objectives', 'passmark_percentage', 'is_public'];

    protected $filterable = [
        'description' => LikeFilter::class,
        'overview' => LikeFilter::class,
        'objectives' => LikeFilter::class,
        'passmark_percentage' => WhereFilter::class,
        'is_public' => WhereFilter::class,
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    public function employees()
    {
        return $this->belongsToMany('App\Employee')
                ->select(['first_name', 'surname'])
                ->wherePivot('is_active', '=', 1);
    }

    public function trainingSessions()
    {
        return $this->hasMany(CourseTrainingSession::class);
    }

}
