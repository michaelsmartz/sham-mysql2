<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

class Employee extends Model
{
    use Mediable;
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'title_id',
                  'initials',
                  'first_name',
                  'surname',
                  'known_as',
                  'birth_date',
                  'marital_status_id',
                  'id_number',
                  'passport_country_id',
                  'nationality',
                  'language_id',
                  'gender_id',
                  'ethnic_group_id',
                  'immigration_status_id',
                  'time_group_id',
                  'passport_no',
                  'spouse_full_name',
                  'employee_no',
                  'employee_code',
                  'tax_number',
                  'tax_status_id',
                  'date_joined',
                  'date_terminated',
                  'department_id',
                  'team_id',
                  'employee_status_id',
                  'physical_file_no',
                  'job_title_id',
                  'division_id',
                  'branch_id',
                  'picture',
                  'line_manager_id',
                  'leave_balance_at_start'
              ];

    protected $dates = ['deleted_at'];

    protected $with = ['department', 'jobTitle'];

    public $searchable = ['first_name', 'surname'];

    //protected $appends = ['emails'];

    protected static function boot()
    {
        parent::boot();
    
        static::addGlobalScope('employeeFullName', function (Builder $builder) {
			if(is_null($builder->getQuery()->columns)){
				$builder->addSelect('*');
			}
            $builder->addSelect(DB::raw('CONCAT(first_name, " ", surname) AS full_name'));
        });
    }
	
    public function scopeEmployeesLite($query)
    {
        $this->withEmployeesLite($query);
    }

    protected function withEmployeesLite($query)
    {
        $query->select(['job_title_id','first_name','surname','id'])
              ->whereNull('deleted_at');
    }

    /**
     * Get full name
     * @return string
    */
    /*public function getFullNameAttribute(){
        return $this->first_name . ' ' . $this->surname;
    }*/

    public function disabilities()
    {
        return $this->hasMany('App\Disability','disability_id','id');
    }

    public function title()
    {
        return $this->belongsTo('App\Title','title_id','id');
    }

    public function maritalstatus()
    {
        return $this->belongsTo('App\Maritalstatus','marital_status_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country','passport_country_id','id');
    }

    public function language()
    {
        return $this->belongsTo('App\Language','language_id','id');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender','gender_id','id');
    }

    public function ethnicGroup()
    {
        return $this->belongsTo('App\EthnicGroup','ethnic_group_id','id');
    }

    public function immigrationStatus()
    {
        return $this->belongsTo('App\ImmigrationStatus','immigration_status_id','Id');
    }

    public function timeGroup()
    {
        return $this->belongsTo('App\TimeGroup','time_group_id');
    }

    public function taxstatus()
    {
        return $this->belongsTo('App\Taxstatus','tax_status_id','id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function team()
    {
        return $this->belongsTo('App\Team','team_id','Id');
    }

    public function employeeStatus()
    {
        return $this->belongsTo('App\EmployeeStatus','employee_status_id','id');
    }

    public function jobTitle()
    {
        return $this->belongsTo('App\JobTitle');
    }

    public function division()
    {
        return $this->belongsTo('App\Division','division_id','id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch','branch_id','id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address','employee_id','id')
        ->whereIn('address_type_id', [1,2]);
    }

    /*
    public function homeAddress(){
        return $this->hasOne('App\Address','employee_id','id')
                    ->where('address_type_id', '=', 1);
    }

    public function postalAddress(){
        return $this->hasOne('App\Address','employee_id','id')
                    ->where('address_type_id', '=', 2);
    }
    */

    public function assetallocation()
    {
        return $this->hasOne('App\Assetallocation','employee_id','id');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course')->wherePivot('is_active', '=', 1);
    }

    public function commentdetail()
    {
        return $this->hasOne('App\Commentdetail','employee_id','id');
    }

    public function courseDiscussion()
    {
        return $this->hasOne('App\CourseDiscussion','employee_id','id');
    }

    public function courseEmployees()
    {
        return $this->hasMany('App\CourseEmployee','employee_id','id');
    }

    public function courseProgresses()
    {
        return $this->hasMany('App\CourseProgress','employee_id','id');
    }

    public function disciplinaryActions()
    {
        return $this->hasMany('App\DisciplinaryAction','employee_id','id');
    }

    public function emails()
    {
        return $this->hasMany('App\EmailAddress','employee_id','id')
                    ->whereIn('email_address_type_id', [1,2]);
    }

    /*
    public function privateEmail()
    {
        return $this->hasOne('App\EmailAddress','employee_id','id')
                    ->where('email_address_type_id', '=', 1);
    }

    public function workEmail()
    {
        return $this->hasOne('App\EmailAddress','employee_id','id')
                    ->where('email_address_type_id', '=', 2);
    }
    */

    public function employeeAttachment()
    {
        return $this->hasOne('App\EmployeeAttachment','employee_id','id');
    }

    public function employeeSkills()
    {
        return $this->hasMany('App\EmployeeSkill','employee_id','id');
    }

    public function evaluationassessors()
    {
        return $this->hasMany('App\Evaluationassessor','EmployeeId','id');
    }

    public function evaluationresult()
    {
        return $this->hasOne('App\Evaluationresult','AssessorEmployeeId','id');
    }

    public function evaluation()
    {
        return $this->hasOne('App\Evaluation','UserEmployeeId','id');
    }

    public function evaluations()
    {
        return $this->hasMany('App\Evaluation','CreatedByEmployeeId','id');
    }

    public function eventtaskinstances()
    {
        return $this->hasMany('App\Eventtaskinstance','TargetId','id');
    }

    public function historydepartments()
    {
        return $this->hasMany('App\Historydepartment','EmployeeId','id');
    }

    public function historydisciplinaryactions()
    {
        return $this->hasMany('App\Historydisciplinaryaction','EmployeeId','id');
    }

    public function historyjobtitles()
    {
        return $this->hasMany('App\Historyjobtitle','EmployeeId','id');
    }

    public function historyjoinsterminations()
    {
        return $this->hasMany('App\Historyjoinstermination','EmployeeId','id');
    }

    public function historyqualification()
    {
        return $this->hasOne('App\Historyqualification','EmployeeId','id');
    }

    public function historyrewards()
    {
        return $this->hasMany('App\Historyreward','EmployeeId','id');
    }

    public function historytraining()
    {
        return $this->hasOne('App\Historytraining','EmployeeId','id');
    }

    public function moduleassessmentresponses()
    {
        return $this->hasMany('App\Moduleassessmentresponse','EmployeeId','id');
    }

    public function moduleassessments()
    {
        return $this->hasMany('App\Moduleassessment','TrainerId','id');
    }

    public function qualifications()
    {
        return $this->hasMany('App\Qualification','employee_id','id');
    }

    public function recruitmentrequest()
    {
        return $this->hasOne('App\Recruitmentrequest','HiringManagerEmployeeId','id');
    }

    public function rewards()
    {
        return $this->hasMany('App\Reward','employee_id','id');
    }

    public function shamusers()
    {
        return $this->hasMany('App\Shamuser','EmployeeId','id');
    }

    public function phones()
    {
        return $this->hasMany('App\TelephoneNumber','employee_id','id')
                    ->whereIn('telephone_number_type_id', [1,2,3]);
    }
    
    /*
    public function homePhone()
    {
        return $this->hasOne('App\TelephoneNumber','employee_id','id')
                    ->where('telephone_number_type_id', '=', 1);
    }

    public function mobilePhone()
    {
        return $this->hasOne('App\TelephoneNumber','employee_id','id')
                    ->where('telephone_number_type_id', '=', 2);
    }

    public function workPhone()
    {
        return $this->hasOne('App\TelephoneNumber','employee_id','id')
                    ->where('telephone_number_type_id', '=', 3);
    }
    */

    public function timelines()
    {
        return $this->hasMany('App\Timeline','EmployeeId','id');
    }

    public function trainingsessionparticipant()
    {
        return $this->hasOne('App\Trainingsessionparticipant','EmployeeId','id');
    }

}