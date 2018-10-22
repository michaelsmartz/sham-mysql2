@extends('portal-index')
@section('title','Instances')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">

            <div class="table-responsive">
            @if(count($evaluations) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new evaluation</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Assessment</th>
                            <th data-sortable="true">Employee</th>
                            <th data-sortable="true">Department</th>
                            <th data-sortable="true">Feedback Date</th>
                            <th data-sortable="true">Evaluation Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluations as $evaluation)
                        <tr id="tr{{$evaluation->id}}">
                            <td>{{ optional($evaluation->assessment)->name }}</td>
                            <td>{{ optional($evaluation->employee)->first_name }}</td>
                            <td>{{ optional($evaluation->department)->description }}</td>
                            <td>{{ $evaluation->feedback_date }}</td>
                            <td>{{ optional($evaluation->evaluationStatus)->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $evaluations->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'evaluations.destroy'])
            @endcomponent
        </div>
    </div>
@endsection