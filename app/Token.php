<?php

namespace App;

use App\Traits\HasBaseModel;

class Token extends Model
{
    use HasBaseModel;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'api_token'
    ];

    public function user () {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}