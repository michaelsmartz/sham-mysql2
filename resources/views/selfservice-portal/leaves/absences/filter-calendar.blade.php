<div class="container @if($_SERVER['REQUEST_URI'] == '/my-leaves-pending-request' || (isset($filter) && $filter['leave_status'] == App\Enums\LeaveStatusType::status_pending))col-md-5 @else col-md-3 @endif">
    <form method="POST" action="{{route('my-leaves.filter-calendar')}}" id="leave_request_filter" name="leave_request_filter" accept-charset="UTF-8" class="form-horizontal">
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
                <button id="btn-filter-date" class="btn btn-primary btn-filter" type="submit"><i class="glyphicon glyphicon-sort"></i> Filter</button>
                <a href="{{route('my-leaves.index')}}" class="btn btn-primary btn-filter"><i class="glyphicon glyphicon-refresh"></i> Reset</a>
                @if($_SERVER['REQUEST_URI'] == '/my-leaves-pending-request' || (isset($filter) && $filter['leave_status'] == App\Enums\LeaveStatusType::status_pending))
                    <input name="leave_status" id="leave_status" value="{{App\Enums\LeaveStatusType::status_pending}}" type="hidden">
                @else
                    <input name="leave_status" id="leave_status" value="{{App\Enums\LeaveStatusType::status_approved}}" type="hidden">
                @endif
            </div>
            @if($_SERVER['REQUEST_URI'] == '/my-leaves-pending-request' || (isset($filter) && $filter['leave_status'] == App\Enums\LeaveStatusType::status_pending))
            <div class="form-group col-lg-4 batch-filter">
                <label for="batch_operation"><input type="checkbox" id="bundle_check" value="0">  <span class="glyphicon glyphicon-check"></span> Batch operation</label>
                <select class="form-control" id="batch_operation" name="batch_operatione">
                    <option value="0">Select batch operation</option>
                    <option value="{{App\Enums\LeaveStatusType::status_approved}}">Approve selected</option>
                    <option value="{{App\Enums\LeaveStatusType::status_denied}}">Deny selected</option>
                </select>
                <button id="bundle_submit" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Execute batch</button>
                <input name="leave_list" id="leave_list" value="" type="hidden">
            </div>
            @endif
        @endif
    </form>


</div>
<br>