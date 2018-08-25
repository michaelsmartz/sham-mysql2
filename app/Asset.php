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
                  'asset_group_id',
                  'asset_supplier_id',
                  'tag',
                  'serial_no',
                  'purchase_price',
                  'po_number',
                  'warranty_expiry_date',
                  'asset_condition_id',
                  'comments',
                  'is_available'
              ];

    public function assetGroup()
    {
        return $this->belongsTo('App\AssetGroup','asset_group_id','id');
    }

    public function assetSupplier()
    {
        return $this->belongsTo('App\AssetSupplier','asset_supplier_id','id');
    }

    public function assetCondition()
    {
        return $this->belongsTo('App\AssetCondition','asset_condition_id','id');
    }

    public function assetEmployees()
    {
        return $this->belongsToMany('App\Employee');
    }


}