@extends('portal-index')
@section('title','System Configuration')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/users">Users</a></li>
        <li class="active"><a href="#">User Profiles</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($shamUserProfiles) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($shamUserProfiles) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new sham user profile</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Name</th>
                            <th data-sortable="true">Description</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shamUserProfiles as $shamUserProfile)
                        <tr id="tr{{$shamUserProfile->id}}">
                                                        <td>{{ $shamUserProfile->name }}</td>
                            <td>{{ $shamUserProfile->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$shamUserProfile->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <a href="#light-modal" data-wenk="Permission Matrix" class="b-n b-n-r bg-transparent item-matrix" onclick="matrixForm('{{$shamUserProfile->id}}', event)">
                                        <i class="glyphicon glyphicon-th text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$shamUserProfile->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $shamUserProfiles->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'sham_user_profiles.destroy'])
            @endcomponent
        </div>
    </div>
@endsection