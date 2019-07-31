<div class="container col-md-7">
    <form method="POST" action="{{route('my-leaves.filter-calendar')}}" id="leave_request_filter" name="leave_request_filter" accept-charset="UTF-8" class="form-horizontal">
        @if(is_array($employees) && (count($employees)>0))
            <div class="form-group col-lg-4">
                <i class="glyphicon glyphicon-user"></i> Employee
                <select class="form-control select-leave-filters" id="employee_id" name="employee_id">
                    <option value="{{$manager['id']}}">{{$manager['fullname']}}</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" @if(!empty($selected['employee']->id) && $selected['employee']->id == $employee->id) selected @endif>
                            {{ $employee->first_name }} {{ $employee->surname }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if($_SERVER['REQUEST_URI'] == '/my-leaves-pending-request' || (isset($filter) && $filter['leave_status'] == App\Enums\LeaveStatusType::status_pending))
                <input name="leave_status" id="leave_status" value="{{App\Enums\LeaveStatusType::status_pending}}" type="hidden">
            @else
                <input name="leave_status" id="leave_status" value="{{App\Enums\LeaveStatusType::status_approved}}" type="hidden">
            @endif

            <div class="form-group col-lg-2 btn-leave-command">
                <button id="btn-filter-date" type="submit" class="btn btn-primary" data-wenk="Filter by employee"><i class="fa fa-filter"></i></button>
                <a href="@if($_SERVER['REQUEST_URI'] == '/my-leaves-pending-request' || (isset($filter) && $filter['leave_status'] == App\Enums\LeaveStatusType::status_pending)){{route('my-leaves.pending')}} @else {{route('my-leaves.index')}} @endif" role="button" class="btn btn-primary" data-wenk="Reset all Criteria"><i class="fa fa-refresh"></i></a>
            </div>

            @if($_SERVER['REQUEST_URI'] == '/my-leaves-pending-request' || (isset($filter) && $filter['leave_status'] == App\Enums\LeaveStatusType::status_pending))
                <div class="form-group col-lg-4">
                    <i class="fa fa-check"></i> Batch operation <input type="checkbox" id="bundle_check" value="0">
                    <select class="form-control select-leave-filters" id="batch_operation" name="batch_operatione">
                        <option value="0">Select batch operation</option>
                        <option value="{{App\Enums\LeaveStatusType::status_approved}}">Approve selected</option>
                        <option value="{{App\Enums\LeaveStatusType::status_denied}}">Deny selected</option>
                    </select>
                    <button id="bundle_submit" data-wenk="Execute batch" class="btn btn-primary" type="button"><i class="fa fa-save"></i></button>
                    <input name="leave_list" id="leave_list" value="" type="hidden">
                </div>
            @endif
        @endif
    </form>


</div>
<br>