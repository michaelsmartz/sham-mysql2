@extends('portal-index')
@section('title','Branches')
@section('subtitle','Branch drop-down values for employees')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($branches) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    @if($allowedActions->contains('Create'))
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                    @endif
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($branches) == 0)
                <h4 class="text-center">Its a bit empty here.
                @if($allowedActions->contains('Create'))
                    You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new branch
                @endif
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Company</th>
                            <th data-sortable="true">Description</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($branches as $branch)
                        <tr id="tr{{$branch->id}}">
                            <td>{{ optional($branch->company)->name }}</td>
                            <td>{{ $branch->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$branch->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    @endif
                                    @if($allowedActions->contains('Delete'))
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$branch->id}}')">
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
                    {!! $branches->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'branches.destroy'])
            @endcomponent
        </div>
    </div>
@endsection