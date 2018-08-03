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
                  'maritalstatus_id',
                  'id_number',
                  'passportcountry_id',
                  'nationality',
                  'language_id',
                  'gender_id',
                  'ethnicgroup_id',
                  'immigrationstatus_id',
                  'passport_no',
                  'spouse_full_name',
                  'employee_no',
                  'employee_code',
                  'tax_number',
                  'taxstatus_id',
                  'date_joined',
                  'date_terminated',
                  'department_id',
                  'team_id',
                  'employeestatus_id',
                  'physical_file_no',
                  'jobtitle_id',
                  'division_id',
                  'branch_id',
                  'picture',
                  'linemanager_id'
              ];

    public function title()
    {
        return $this->belongsTo('App\Title','title_id');
    }

    public function maritalstatus()
    {
        return $this->belongsTo('App\Maritalstatus','maritalstatus_id');
    }

    public function passportcountry()
    {
        return $this->belongsTo('App\Passportcountry','passportcountry_id');
    }

    public function language()
    {
        return $this->belongsTo('App\Language','language_id');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender','gender_id');
    }

    public function ethnicgroup()
    {
        return $this->belongsTo('App\Ethnicgroup','ethnicgroup_id');
    }

    public function immigrationstatus()
    {
        return $this->belongsTo('App\Immigrationstatus','immigrationstatus_id');
    }

    public function timegroup()
    {
        return $this->belongsTo('App\Timegroup','timegroup_id');
    }

    public function taxstatus()
    {
        return $this->belongsTo('App\Taxstatus','taxstatus_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department','department_id');
    }

    public function team()
    {
        return $this->belongsTo('App\Team','team_id');
    }

    public function employeestatus()
    {
        return $this->belongsTo('App\Employeestatus','employeestatus_id');
    }

    public function jobtitle()
    {
        return $this->belongsTo('App\Jobtitle','jobtitle_id');
    }

    public function division()
    {
        return $this->belongsTo('App\Division','division_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch','branch_id');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course')->wherePivot('is_active', '=', 1);
    }

}