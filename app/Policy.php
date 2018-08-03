<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Policy extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'title',
                  'content',
                  'policycategory_id',
                  'expires_on',
                  'is_active'
              ];

    /**
     * Get the policycategory for this model.
     */
    public function policyCategory()
    {
        return $this->hasOne('App\PolicyCategory','id','policycategory_id');
    }

    public function policyDocuments()
    {
      return $this->hasMany(PolicyDocument::class);
    } 


}