@extends('portal-index')
@if(is_null($selected_employee))
    @section('title','Leaves Histories')
@else
    @section('title','Leaves Histories for '. optional($selected_employee)->full_name)
@endif
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(!is_null($current_employee) && optional($current_employee->jobTitle)->is_manager)
                <div class="form-group col-xs-5">
                    <div class="h4 text-info">List of leaves from and to selected date</div>
                    <div class="text-danger">NOTE:</div>
                    <div class="text-danger">1. If no date and no employee selected, table will list leaves for the current associated employee</div>
                    <div class="text-danger">2. If only date selected, search will display leaves for current associated employee</div>
                    <div class="text-danger">for that particular date</div>
                    <div class="text-danger">3. If date and employee selected, search will display leaves for selected employee</div>
                    <div class="text-danger">for that particular date</div>
                </div>
                <form action="{{ route('history_leaves.index') }}" class="search_employee_leaves">
                    <div class="row">
                        <div class="form-group col-xs-2">
                            {!! Form::text('from','', ['class'=>'form-control datepicker', 'autocomplete'=>'off',  'placeholder'=>'From', 'id'=>'from' ]) !!}
                        </div>

                        <div class="form-group col-xs-3 absence_type">
                            <select class="form-control" id="absence_type" name="absence_type">
                                <option value="0">Select leave type</option>
                                @foreach ($eligibility as $leave)
                                    <option value="{{ $leave->id }}"  @if(!empty($absence_type) && $absence_type == $leave->id) selected @endif>
                                        {{ $leave->absence_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-xs-2">
                            {!! Form::text('to','', ['class'=>'form-control datepicker', 'autocomplete'=>'off', 'placeholder'=>'To', 'id'=>'to']) !!}
                        </div>
                        <div class="form-group col-xs-4">
                            <select class="form-control" id="employee" name="employee">
                                <option value="" style="display: none;" disabled selected>Select Employee</option>
                                @foreach ($employees as $key => $employee)
                                    <option class="select-items" value="{{ $key }}">
                                        {{ $employee }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sham" data-wenk="Search for other employee's leaves" data-wenk-pos="top">
                                <i class="fa fa-search"></i>
                            </button>
                            <a href="{{route('history_leaves.index')}}" class="btn btn-info" role="button" data-wenk="Reset and view your leaves" data-wenk-pos="top">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                    </div>
                </form>
            @endif
            <div class="table-responsive">
            @if(count($leaves)>0)
                <table id="new-table" data-toggle="table">
                    <thead>
                    <tr>
                        <th scope="col">Leave type</th>
                        <th scope="col">Starts on</th>
                        <th scope="col">Ends on</th>
                        <th scope="col">Status</th>
                        <th scope="col">Taken</th>
                        <th scope="col">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leaves as $leave)
                        <tr class="data-history">
                            <td>{{$leave->absence_description}}</td>
                            <td>{{ (new DateTime($leave->starts_at))->format('Y-m-d')}}</td>
                            <td>{{ (new DateTime($leave->ends_at))->format('Y-m-d')}}</td>
                            <td class="center">
                                @switch($leave->status)
                                    @case(3)
                                    <span class="badge badge-status badge-secondary">Cancelled</span>
                                    @break

                                    @case(2)
                                    <span class="badge badge-status badge-danger">Denied</span>
                                    @break

                                    @case(1)
                                    <span class="badge badge-status badge-success">Approved</span>
                                    @break

                                    @default
                                    <span class="badge badge-status badge-warning">Pending</span>
                                @endswitch
                            </td>
                            <td>{{number_format($leave->taken,1)}}</td>
                            <td>{{number_format($leave->remaining,1)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="container-fluid panel">
                    <div class="text-success">Currently, there are no leave types allocated to you</div>
                </div>
            @endif
            </div>
            @component('partials.index')
            @endcomponent
        </div>
    </div>
@endsection

@section('post-body')
    <style>
        form.search_employee_leaves{
            padding-top: 10px;
        }

        form.search_employee_leaves #employee
        {
            float: left;
            width: 80%;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0
        }

        form.search_employee_leaves button {
            float: left;
            width: 10%;
            border-radius: 0;
        }

        form.search_employee_leaves a {
            float: left;
            width: 10%;
            border-bottom-left-radius: 0;
            border-top-left-radius: 0;
        }

    </style>
@endsection