<div class="container col-md-7">
    <form method="POST" action="{{route('leaves.filter-calendar')}}" id="leave_request_filter" name="leave_request_filter" accept-charset="UTF-8" class="form-horizontal">
        <div class="form-group col-lg-2 employee-filter">
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
        @if(count($employees)>0)
            <div class="form-group col-lg-2 employee-filter">
                <label for="employee_id"><span class="glyphicon glyphicon-user"></span> Employee</label>
                <select class="form-control" id="employee_id" name="employee_id">
                    <option value="{{$manager['id']}}">{{$manager['fullname']}}</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" @if(!empty($selected['employee']->id) && $selected['employee']->id == $employee->id) selected @endif>
                            {{ $employee->first_name }} {{ $employee->surname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-3 employee-filter">
                <label for="batch_operation"><input type="checkbox" id="bundle_check" value="0">  <span class="glyphicon glyphicon-check"></span> Batch operation</label>
                <select class="form-control" id="batch_operation" name="batch_operatione">
                    <option value="0">Select batch operation</option>
                    <option value="{{App\Enums\LeaveStatusType::status_approved}}">Approve selected</option>
                    <option value="{{App\Enums\LeaveStatusType::status_denied}}">Deny selected</option>
                </select>
            </div>
            <button id="bundle_submit" type="button" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-save"></i> Execute batch</button>
            <input name="leave_list" id="leave_list" value="" type="hidden">
        @endif
    </form>


</div>
<br>