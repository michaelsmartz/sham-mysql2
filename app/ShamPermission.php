<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShamPermission extends Model
{

    protected $casts = [
        'id'   => 'integer',
        'Name' => 'string',
        'Description' => 'string',
        'Active'=>'boolean',
    ];

    protected $guarded = [
        'id'   => 'integer',
    ];

    protected $fillable = [
        'Name',
        'Description',
        'Active',
    ];


    /**
     * Get an array of fields for the search filters in format key=>value
     * where key is the Field Name and Value is a field description
     * @return array
     */
    public static function getSearcheableFields()
    {
        return array(
            'Name'=>' Name',
            'Description'=>' Description',
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
            'Name'=>' Name',
            'Description'=>' Description',

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

    public function shamUserProfiles() {
        return $this->belongsToMany('App\ShamUserProfile', 'sham_permission_sham_user_profile_system_sub_module');
    }

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_SYSTEM_CONFIGURATION;
    protected static $api = "ShamPermissions";
    protected $table = 'sham_permissions';
}
?>
