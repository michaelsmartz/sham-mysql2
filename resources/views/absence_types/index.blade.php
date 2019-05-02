@extends('portal-index')
@section('title','Absence Types')
@section('content')
    <div class="flex-wrapper">
        <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation">
            <form action="" class="">
                <ul style="margin-left:0;padding-left:0" class="list-unstyled">
                    <li>
                        <input type="hidden" name="name" class="submitable-column-name" id="submitable-column-name" value="">
                        <div class="table-search-form">
                            <input type="search" name="search-term" value="{{old('search-term', null)}}" placeholder="Search" class="search-input" data-mirror="#submitable-column-name">
                            <div class="search-option">
                                <button type="submit" data-wenk="Do the Search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{route('absence_types.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="table-search-form" style="height:50px">
                            <button type="button" class="search-column-chooser-btn">
                                <p class="search-small">Search by</p>
                                <p class="search-large">Name</p>
                            </button>
                        </div>
                        <ul class="search-column-list">
                            <li data-filter-column="description">By Description</li>
                            <li data-filter-column="eligibility_begins">By Eligibility Begins</li>
                            <li data-filter-column="eligibility_ends">By Eligibility Ends</li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        <div id="table-container">
            @if(count($absenceTypes) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    @if($allowedActions->contains('Create'))
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                    @endif
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($absenceTypes) == 0)
                <h4 class="text-center">Its a bit empty here.
                    @if($allowedActions->contains('Create'))
                    You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new absence type
                    @endif
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Description</th>
                            <th data-sortable="true">Duration</th>
                            <th data-sortable="true">Eligibility Start</th>
                            <th data-sortable="true">Eligibility End</th>
                            <th data-sortable="true">Accrue Period</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absenceTypes as $absenceType)
                        <tr id="tr{{$absenceType->id}}">
                            <td>{{ $absenceType->description }}</td>
                            <td>{!! App\Enums\LeaveDurationUnitType::getDescription($absenceType->duration_unit) !!}</td>
                            <td>{!! App\Enums\LeaveEmployeeGainEligibilityType::getDescription($absenceType->eligibility_begins) !!}</td>
                            <td>{!! App\Enums\LeaveEmployeeLossEligibilityType::getDescription($absenceType->eligibility_ends) !!}</td>
                            <td>{!! App\Enums\LeaveAccruePeriodType::getDescription($absenceType->accrue_period) !!}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                        <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$absenceType->id}}', event)">
                                            <i class="glyphicon glyphicon-edit text-primary"></i>
                                        </a>
                                    @endif
                                    @if($allowedActions->contains('Delete'))
                                        <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$absenceType->id}}')">
                                            <i class="glyphicon glyphicon-remove text-danger"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $absenceTypes->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'absence_types.destroy'])
            @endcomponent
        </div>
    </div>
@endsection