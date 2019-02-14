<?php

namespace App;

use San4io\EloquentFilter\Filters\LikeFilter;

class AssetEmployee extends Model
{
    protected $table = "asset_employee";

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'asset_id',
                  'employee_id',
                  'date_out',
                  'date_in',
                  'comment'
              ];

    public $searchable = ['asset:name', 'asset:tag', 'employee:full_name', 'date_out', 'date_in'];

    protected $filterable = [
        'asset:name' => LikeFilter::class,
        'asset:tag' => LikeFilter::class,
        'employee:full_name' => LikeFilter::class,
        'date_out' => LikeFilter::class,
        'date_in' => LikeFilter::class
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset','asset_id','id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id','id')
                    ->select(['id']);
    }


}