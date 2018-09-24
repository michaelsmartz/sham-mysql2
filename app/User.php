<?php

namespace App;

use App\Traits\HasBaseModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Events\UserAmended;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jedrzej\Searchable\SearchableTrait;
use San4io\EloquentFilter\Traits\Filterable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasBaseModel, SearchableTrait, Filterable;

    protected $dispatchesEvents = [
        'saved' => UserAmended::class,
        'deleted' => UserAmended::class,
        'restored' => UserAmended::class,
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'cell_number',
        'sham_user_profile_id',
        'silence_start',
        'silence_end'
    ];


    public $searchable = ['username', 'email_address'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function shamUserProfile()
    {
        return $this->hasOne(ShamUserProfile::class, 'id', 'sham_user_profile_id');
    }
    

    public function getAuthorisedModules()
    {
        $retVal = array();
        
        /*
		$permissions = \App\ShamUserProfilesSubModulePermission::selectWithExpand(['SystemSubModule'], "SystemSubModule(\$select=Id,;\$expand=SystemModule(\$select=Id))", "ShamUserProfileId eq ".$this->ShamUserProfileId."and SystemSubModule/Active eq true and SystemSubModule/SystemModule/Active eq true");
		if ($permissions != null && property_exists($permissions,'value')) {
			foreach ($permissions->value as $permissionItem) {
				$retVal[$permissionItem->SystemSubModule->SystemModule->Id][$permissionItem->SystemSubModule->Id] = 1;
			}
        }
        */
        

		return $retVal;

    }

    public function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }


}
