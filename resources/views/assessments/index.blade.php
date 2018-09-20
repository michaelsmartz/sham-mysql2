@extends('portal-index')
@section('title','Assessments')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($assessments) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($assessments) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new assessment</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Name</th>
                            <th data-sortable="true">Description</th>
                            <th data-sortable="true">Passmark Percentage</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assessments as $assessment)
                        <tr id="tr{{$assessment->id}}">
                                                        <td>{{ $assessment->name }}</td>
                            <td>{{ $assessment->description }}</td>
                            <td>{{ $assessment->passmark_percentage }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#modal-text" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$assessment->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
                                    <a href="#!" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$assessment->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $assessments->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'assessments.destroy'])
            @endcomponent
        </div>
    </div>
@endsection