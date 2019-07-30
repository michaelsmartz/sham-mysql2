<div class="container-fluid">
    <form method="POST" action="{{route('my-leaves.filter')}}" id="leave_request_filter" name="leave_request_filter" accept-charset="UTF-8" class="form-horizontal">
        <div class="row">
            <div class="col-lg-11">
                <legend><i class="glyphicon glyphicon-filter"></i>  Filters</legend>
            </div>
            <div class="col-lg-1 btn-leave-command">
                <button id="btn-filter-date" type="submit" class="btn btn-primary" data-wenk="Filter"><i class="fa fa-filter"></i></button>
                <a href="{{route('my-leaves.history')}}" role="button" class="btn btn-primary" data-wenk="Reset all Criteria"><i class="fa fa-refresh"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-3">
                <label for="absence_type"><span class="glyphicon glyphicon-tasks"></span> Leave type</label>
                <select class="form-control" id="absence_type" name="absence_type">
                    <option value="0">Select leave type</option>
                    @foreach ($eligibility as $leave)
                        <option value="{{ $leave->id }}"  @if(!empty($selected['absence_id']) && $selected['absence_id'] == $leave->id) selected @endif>
                            {{ $leave->absence_description }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label for="status"><span class="glyphicon glyphicon-stats"></span> Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="-1">Select status</option>
                    <option @if(!empty($selected['status']) && $selected['status'] == App\Enums\LeaveStatusType::status_approved) selected @endif value="{{App\Enums\LeaveStatusType::status_approved}}">{{App\Enums\LeaveStatusType::getDescription(App\Enums\LeaveStatusType::status_approved)}}</option>
                    <option @if(!empty($selected['status']) && $selected['status'] == App\Enums\LeaveStatusType::status_pending) selected @endif value="{{App\Enums\LeaveStatusType::status_pending}}">{{App\Enums\LeaveStatusType::getDescription(App\Enums\LeaveStatusType::status_pending)}}</option>
                    <option @if(!empty($selected['status']) && $selected['status'] == App\Enums\LeaveStatusType::status_cancelled) selected @endif value="{{App\Enums\LeaveStatusType::status_cancelled}}">{{App\Enums\LeaveStatusType::getDescription(App\Enums\LeaveStatusType::status_cancelled)}}</option>
                    <option @if(!empty($selected['status']) && $selected['status'] == App\Enums\LeaveStatusType::status_denied) selected @endif value="{{App\Enums\LeaveStatusType::status_denied}}">{{App\Enums\LeaveStatusType::getDescription(App\Enums\LeaveStatusType::status_denied)}}</option>
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label class="control-label"> <span class="glyphicon glyphicon-calendar"></span> From</label>
                <span>
                    @if(!isset($default_from)) {{$default_from = ''}} @endif
                 {!! Form::text('from',$default_from, ['class'=>'form-control datepicker', 'autocomplete'=>'off',  'placeholder'=>'From', 'id'=>'from' ]) !!}
            </span>
            </div>
            <div class="form-group col-lg-2">
                <label class="control-label"> <span class="glyphicon glyphicon-calendar"></span> To</label>
                <span>
                @if(!isset($default_to)) {{$default_to = ''}} @endif
                {!! Form::text('to',$default_to, ['class'=>'form-control datepicker', 'autocomplete'=>'off', 'placeholder'=>'To', 'id'=>'to']) !!}
            </span>
            </div>
            @if(is_array($employees) && (count($employees)>0))
                <div class="form-group col-lg-3">
                    <label for="employee_id"><span class="glyphicon glyphicon-user"></span> Employee</label>
                    <select class="form-control" id="employee_id" name="employee_id">
                        <option value="0">Select employee</option>
                        <option value="{{$manager['id']}}">{{$manager['fullname']}}</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @if(!empty($selected['employee']->id) && $selected['employee']->id == $employee->id) selected @endif>
                                {{ $employee->first_name }} {{ $employee->surname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    </form>
</div>
<br>