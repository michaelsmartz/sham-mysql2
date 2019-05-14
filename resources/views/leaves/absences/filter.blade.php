<div class="container-fluid">
    <form method="POST" action="{{route('leaves.filter')}}" id="leave_request_filter" name="leave_request_filter" accept-charset="UTF-8" class="form-horizontal">
        <legend><i class="glyphicon glyphicon-filter"></i>  Filters</legend>
        @if(count($employees)>0)
            <div class="form-group col-lg-2 employee-filter">
                <label for="employee_id"><span class="glyphicon glyphicon-user"></span> Employee</label>
                <select class="form-control" id="employee_id" name="employee_id">
                    <option value="0">Select employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">
                            {{ $employee->first_name }} {{ $employee->surname }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="form-group col-lg-2 employee-filter">
            <label for="absence_type"><span class="glyphicon glyphicon-tasks"></span> Leave type</label>
            <select class="form-control" id="absence_type" name="absence_type">
                <option value="0">Select leave type</option>
                @foreach ($eligibility as $leave)
                    <option value="{{ $leave->absence_description }}">
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
        <div class="form-group col-lg-4 pull-right">
            <a id="btn-filter-date" class="btn btn-primary btn-filter" href="javascript:void(0)" onclick="filter()"><i class="glyphicon glyphicon-sort"></i> Filter</a>
            <a href="{{route('leaves.index')}}" class="btn btn-primary btn-filter"><i class="glyphicon glyphicon-refresh"></i> Reset</a>
        </div>
    </form>
</div>
<br>