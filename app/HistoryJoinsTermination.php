<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryJoinsTermination extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history_joins_terminations';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'is_joined',
        'date_occurred'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }
}
