@extends('portal-index')
@section('title','Entitlements')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(!is_null($current_employee) && optional($current_employee->jobTitle)->is_manager)
            <form class="search_employee_entitlements" action="{{ route('entitlements.index') }}">
                <div class="row">
                    <div class="form-group col-xs-3">
                        <input class="form-control datepicker" name="valid_until_date" type="text" id="end_date" value="" placeholder="Enter valid until date here...">
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
                        <button type="submit" class="btn btn-sham" data-wenk="Search for other employee's entitlements" data-wenk-pos="top">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="{{route('entitlements.index')}}" class="btn btn-info" role="button" data-wenk="Reset and view your entitlements" data-wenk-pos="top">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
                <div id="date-picker"></div>
            </form>
            @endif
            <div class="table-responsive">
            @if(count($entitlements) == 0)
                <h4 class="text-center">Its a bit empty here.
                    {{--@if($allowedActions->contains('Create'))--}}
                    {{--You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new entitlement--}}
                    {{--@endif--}}
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Employee Name</th>
                            <th data-sortable="true">Leave Policy</th>
                            <th data-sortable="true">Valid From</th>
                            <th data-sortable="true">Valid To</th>
                            <th data-sortable="true">Total</th>
                            <th data-sortable="true">Taken</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entitlements as $entitlement)
                            @foreach($entitlement->eligibilities as $absenceType)
                            <tr id="tr{{$entitlement->id}}">
                                <td>{{ $entitlement->full_name }}</td>
                                <td>{{ $absenceType->description }}</td>
                                <td>{{ $absenceType->pivot->start_date }}</td>
                                <td>{{ $absenceType->pivot->end_date }}</td>
                                <td>{{ $absenceType->pivot->total }}</td>
                                <td>{{ $absenceType->pivot->taken }}</td>

                                <td data-html2canvas-ignore="true">
                                    <div class="btn-group btn-group-xs" role="group">
                                        @if(!is_null($current_employee)
                                         && optional($current_employee->id) != optional($entitlement->id)
                                         && $allowedActions->contains('Write'))
                                            <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$absenceType->pivot->id}}', event)">
                                                <i class="glyphicon glyphicon-edit text-primary"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $entitlements->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'entitlements.destroy'])
            @endcomponent
        </div>
    </div>
@endsection

@section('post-body')
    <style>
        form.search_employee_entitlements{
            padding-top: 10px;
        }

        form.search_employee_entitlements select
        {
            float: left;
            width: 80%;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0
        }

        form.search_employee_entitlements button {
            float: left;
            width: 10%;
            border-radius: 0;
        }

        form.search_employee_entitlements a {
            float: left;
            width: 10%;
            border-bottom-left-radius: 0;
            border-top-left-radius: 0;
        }

        /*style items (options):*/
        /*form.search_employee_entitlements .select-items {*/
            /*height: 100px!important;*/
            /*z-index: 1000;*/
        /*}*/
    </style>
@endsection