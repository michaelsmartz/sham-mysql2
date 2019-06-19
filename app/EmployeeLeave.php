<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'absence_type_employee';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function AbsenceType()
    {
        return $this->belongsTo(AbsenceType::class);
    }

    public function CalendarEvents(){
        return $this->morphMany(CalendarEvent::class,'calendable');
    }

}
