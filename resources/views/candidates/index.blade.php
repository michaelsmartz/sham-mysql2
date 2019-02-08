@extends('portal-index')
@section('title','Candidates')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($candidates) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($candidates) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new candidate</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">First Name</th>
                            <th data-sortable="true">Surname</th>
                            <th data-sortable="true">Email</th>
                            <th data-sortable="true">Phone</th>
                            <th data-sortable="true">Position Applying For</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $candidate)
                        <tr id="tr{{$candidate->id}}">
                            <td>{{ $candidate->first_name }}</td>
                            <td>{{ $candidate->surname }}</td>
                            <td>{{ $candidate->email }}</td>
                            <td>{{ $candidate->phone }}</td>
                            <td>{{ $candidate->position_applying_for }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                        <button type="button" class="b-n b-n-r bg-transparent item-edit" data-wenk="Edit" onclick="editFullPage('{{$candidate->id}}', event)">
                                            <i class="glyphicon glyphicon-edit text-primary"></i>
                                        </button>
                                    @endif
                                    @if($allowedActions->contains('Delete'))
                                        <button type="button" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$candidate->id}}')">
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
                    {!! $candidates->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'candidates.destroy'])
            @endcomponent
        </div>
    </div>
@endsection