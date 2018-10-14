@extends('portal-index')
@section('title','Timeline')
@section('subtitle', 'All employees milestones in one place')
@section('right-title')
    <a href="{{route('employees.index') }}" class="btn btn-default pull-right" title="Show all Employees">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection
@section('content')
    {{ AsyncWidget::run('timeline_header', ['employee' => $id]) }}
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('timelines')}}/{{ $id }}">Timeline</a></li>
        <li><a href="{{URL::to('rewards')}}{{'/employee/'}}{{ $id }}">Rewards</a></li>
        <li class="active"><a href="{{URL::to('disciplinaryactions')}}{{'/employee/'}}{{ $id }}">Disciplinary Actions</a></li>
    </ul>
    <br>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($disciplinaryActions) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-create-url="{{route('disciplinaryactions.create')}}" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($disciplinaryActions) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create" data-create-url="{{route('disciplinaryactions.create')}}">here</a> to add a new disciplinary action</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Violation</th>
                            <th data-sortable="true">Violation Date</th>
                            <th data-sortable="true">Employee Statement</th>
                            <th data-sortable="true">Employer Statement</th>
                            <th data-sortable="true">Decision</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($disciplinaryActions as $disciplinaryAction)
                        <tr id="tr{{$disciplinaryAction->id}}">
                            <td>{{ optional($disciplinaryAction->violation)->description }}</td>
                            <td>{{ $disciplinaryAction->violation_date }}</td>
                            <td>{{ $disciplinaryAction->employee_statement }}</td>
                            <td>{{ $disciplinaryAction->employer_statement }}</td>
                            <td>{{ $disciplinaryAction->decision }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$disciplinaryAction->id}}', event, '{{\Route::currentRouteName()}}')">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$disciplinaryAction->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $disciplinaryActions->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'disciplinaryactions.destroy'])
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
<link rel="stylesheet" href="{{URL::to('/')}}/css/lifecycle.css">
@endsection