<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShamUserProfile extends Model
{
    use SoftDeletes;
    
    protected $casts = [
        'Id'   => 'integer',
        'Description' => 'string',
        'Active'=>'boolean',
    ];

    protected $guarded = [
        'id'   => 'integer',
    ];

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];


    /**
     * Get an array of fields for the search filters in format key=>value
     * where key is the Field Name and Value is a field description
     * @return array
     */
    public static function getSearcheableFields()
    {
        return array(
            'name'=>' Name',
            'description'=>' Description',
        );
    }

    /**
     * Get an array of fields for the listing table in format key=>value
     * where key is the Field Name and Value is a field description
     * @return array
     */
    public static function getListFields()
    {
        return array(
            'name'=>' Name',
            'description'=>' Description'

        );
    }

//Mutators and Accessors
    public function setActiveAttribute($value)
    {
    	$this->attributes['Active'] = $value ?: null;
    }

    //Custom function to retrieve list for combo box
    public static function getComboList(){
        $arr = self::getList(['Name'], "" , "", "");
        $ret = array();
        $key = self::getKeyId();
        foreach ($arr as $element) {
            $ret[$element->$key]=$element->Name;
        }
        return $ret;
    }

	/**
     * @param $Id - Id of the record for which we need the description
     * @return string description of the field associated to the Id
     */
    public static function GetDescription($Id)
    {
        $item = static::find($Id);
        if ($item!=null) return $item->Name;
        else return "";
    }

    /**
     * Get an array of fields allowed in the Model
     * @return array
     */
    public function getFillableFields()
    {
        return $this->fillable;
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function shamPermissions()
    {
        return $this->belongsToMany('App\ShamPermission','shamuserprofile_shampermission');
    }

    public function systemSubModules()
    {
        return $this->belongsToMany('App\SystemSubModule','shamuserprofile_shampermission')
                ->where('is_active','=',1);
    }

    public function systemModules()
    {
        return $this->hasManyThrough(
            'App\SystemSubModule',
            'shamuserprofile_shampermission',
            'sham_user_profile_id',
            'system_sub_module_id',
            'id',
            'systemmodule_id'
        );
    }

    public function listMatrix()
    {
        $temp = $this->
        join('shamuserprofile_shampermission', 'shamuserprofiles.id', '=', 'shamuserprofile_shampermission.sham_user_profile_id')
        ->join('systemsubmodules', 'shamuserprofile_shampermission.system_sub_module_id', '=', 'systemsubmodules.id')
        ->join('systemmodules', 'systemsubmodules.systemmodule_id', '=', 'systemmodules.id')
        ->select(['systemmodule_id','system_sub_module_id','sham_permission_id'])
        ->where('sham_user_profile_id', '=', $this->id)
        ->get();

        $toReturn = array();
        foreach($temp as $item){

            if(!isset($toReturn[$item['systemmodule_id']])){
                $toReturn[$item['systemmodule_id']] = array();
            }
            if(!isset($toReturn[$item['systemmodule_id']][$item['system_sub_module_id']])){
                $toReturn[$item['systemmodule_id']][$item['system_sub_module_id']] = array();
            }
            $toReturn[$item['systemmodule_id']][$item['system_sub_module_id']] = 1;
        }
        return $toReturn;

    }

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_SYSTEM_CONFIGURATION;
    protected $table = 'shamuserprofiles';
}
?>
