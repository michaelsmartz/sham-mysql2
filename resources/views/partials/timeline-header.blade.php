<br>
<div class="row">
    <div class="col-md-12">
        <section class="panel" style="margin-bottom:15px">
            <div class="panel-body profile-information">
                <div class="col-md-3">
                    <div class="profile-pic text-center">
                        <img src="{{isset($employee)&& isset($employee->picture)?$employee->picture:"/img/avatar.png" }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-desk">
                        <h1>{{ $employee->full_name }}</h1>
                        <span class="text-muted">Start Date: {{ isset($employee) && isset($employee->date_joined)?date('Y-m-d',strtotime($employee->date_joined)):"" }}</span>
                        <p style="display: block;line-height: 2.3">&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="profile-statistics">
                        <h1>{{ isset($employee) && isset($employee->team->description)?$employee->team->description:"" }}</h1>
                        <p>{{ isset($employee) && isset($employee->department->description)?$employee->department->description:"" }}</p>
                        <h1>{{ isset($employee) && isset($employee->branch->description)?$employee->branch->description:"" }}</h1>
                        <p>{{ isset($employee) && isset($employee->division->description)?$employee->division->description:"" }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<br>