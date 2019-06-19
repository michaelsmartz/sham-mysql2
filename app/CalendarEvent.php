<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected  $fillable = ['calendable_id','calendable_type'];

    public function calendable()
    {
        return $this->morphTo();
    }
}
