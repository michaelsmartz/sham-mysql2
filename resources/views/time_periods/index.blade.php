@extends('portal-index')
@section('title','Time Periods')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($timePeriods) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($timePeriods) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new time period</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Start Time</th>
                            <th data-sortable="true">End Time</th>
                            <th data-sortable="true">Time Period Type</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timePeriods as $timePeriod)
                        <tr id="tr{{$timePeriod->id}}">
                                                        <td>{{ $timePeriod->start_time }}</td>
                            <td>{{ $timePeriod->end_time }}</td>
                            <td>{{ $timePeriod->time_period_type }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$timePeriod->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$timePeriod->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $timePeriods->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'time_periods.destroy'])
            @endcomponent
        </div>
    </div>
@endsection