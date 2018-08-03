<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'assetgroup_id',
                  'assetsupplier_id',
                  'assetcondition_id',
                  'tag',
                  'serial_no',
                  'purchase_price',
                  'po_number',
                  'warrantyexpires_at',
                  'comments',
                  'is_available',
                  'is_active'
              ];

    /**
     * Get the assetgroup for this model.
     */
    public function assetGroup()
    {
        return $this->belongsTo('App\AssetGroup','assetgroup_id');
    }

    /**
     * Get the assetsupplier for this model.
     */
    public function assetSupplier()
    {
        return $this->belongsTo('App\AssetSupplier','assetsupplier_id');
    }

    /**
     * Get the assetcondition for this model.
     */
    public function assetCondition()
    {
        return $this->belongsTo('App\AssetCondition','assetcondition_id');
    }


}