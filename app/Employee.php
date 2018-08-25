<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    
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

    
    protected $with = ['department', 'jobTitle'];

    public $searchable = ['first_name', 'surname'];

    protected $appends = ['full_name'];
    
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
    public function getFullNameAttribute(){
        return $this->first_name . ' ' . $this->surname;
    }

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

    public function lineManager()
    {
        return $this->belongsTo('App\LineManager','line_manager_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address','employee_id','id');
    }

    public function assetallocation()
    {
        return $this->hasOne('App\Assetallocation','employee_id','id');
    }

    public function bankingdetail()
    {
        return $this->hasOne('App\Bankingdetail','EmployeeId','id');
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

    public function emailAddresses()
    {
        return $this->hasMany('App\EmailAddress','employee_id','id');
    }

    public function employeeAttachment()
    {
        return $this->hasOne('App\EmployeeAttachment','employee_id','id');
    }

    public function employeeSkills()
    {
        return $this->hasMany('App\EmployeeSkill','employee_id','id');
    }

    public function employeeattendancerecord()
    {
        return $this->hasOne('App\Employeeattendancerecord','EmployeeId','id');
    }

    public function employeesleaveschedule()
    {
        return $this->hasOne('App\Employeesleaveschedule','EmployeeId','id');
    }

    public function employeetimerecords()
    {
        return $this->hasMany('App\Employeetimerecord','UpdatedBy','id');
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

    public function leaveapplicationforms()
    {
        return $this->hasMany('App\Leaveapplicationform','EmployeeId','id');
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

    public function telephoneNumbers()
    {
        return $this->hasMany('App\TelephoneNumber','employee_id','id');
    }

    public function timelines()
    {
        return $this->hasMany('App\Timeline','EmployeeId','id');
    }

    public function trainingsessionparticipant()
    {
        return $this->hasOne('App\Trainingsessionparticipant','EmployeeId','id');
    }

    public function travelexpenseclaims()
    {
        return $this->hasMany('App\Travelexpenseclaim','ReviewerEmployeeId','id');
    }

    public function travelrequests()
    {
        return $this->hasMany('App\Travelrequest','ReviewedByEmployeeId','id');
    }

    public function viewedcomment()
    {
        return $this->hasOne('App\Viewedcomment','EmployeeId','id');
    }


}