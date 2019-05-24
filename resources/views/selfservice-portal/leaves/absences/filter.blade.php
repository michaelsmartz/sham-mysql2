<div class="container-fluid">
    <form method="POST" action="{{route('leaves.filter')}}" id="leave_request_filter" name="leave_request_filter" accept-charset="UTF-8" class="form-horizontal">
        <legend><i class="glyphicon glyphicon-filter"></i>  Filters</legend>
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
        <div class="form-group col-lg-2">
            <div class="">
                <label class="control-label"> <span class="glyphicon glyphicon-calendar"></span> From</label>
                <span class="field w-50">
                     {!! Form::text('from','', ['class'=>'form-control datepicker', 'autocomplete'=>'off',  'placeholder'=>'From', 'id'=>'from' ]) !!}
                    </span>
            </div>
        </div>
        <div class="form-group col-lg-2">
            <div class="">
                <label class="control-label"> <span class="glyphicon glyphicon-calendar"></span> To</label>
                <span class="field w-50">
                    {!! Form::text('to','', ['class'=>'form-control datepicker', 'autocomplete'=>'off', 'placeholder'=>'To', 'id'=>'to']) !!}
                </span>
            </div>
        </div>
        @if(count($employees)>0)
        <div class="form-group col-lg-2 employee-filter">
            <label for="employee_id"><span class="glyphicon glyphicon-user"></span> Employee</label>
            <select class="form-control" id="employee_id" name="employee_id">
                <option value="0">Select employee</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}" @if(!empty($selected['employee_id']) && $selected['employee_id'] == $employee->id) selected @endif>
                        {{ $employee->first_name }} {{ $employee->surname }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="form-group col-lg-4 pull-right">
            <button id="btn-filter-date" class="btn btn-primary btn-filter" type="submit"><i class="glyphicon glyphicon-sort"></i> Filter</button>
            <a href="{{route('leaves.index')}}" class="btn btn-primary btn-filter"><i class="glyphicon glyphicon-refresh"></i> Reset</a>
        </div>
    </form>
</div>
<br>