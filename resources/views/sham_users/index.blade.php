@extends('portal-index')
@section('title','System Configuration')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">Users</a></li>
        <li><a href="{{URL::to('/')}}/sham_user_profiles">User Profiles</a></li>
        <li><a href="{{URL::to('/')}}/general_options">General Options</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($shamUsers) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($shamUsers) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new sham user</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Username</th>
                            <th data-sortable="true">Email Address</th>
                            <th data-sortable="true">Sham User Profile</th>
                            <th data-sortable="true">Employee</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shamUsers as $shamUser)
                        <tr id="tr{{$shamUser->id}}">
                                                        <td>{{ $shamUser->username }}</td>
                            <td>{{ $shamUser->email_address }}</td>
                            <td>{{ optional($shamUser->ShamUserProfileId)->name }}</td>
                            <td>{{ optional($shamUser->employee_id)->first_name }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$shamUser->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$shamUser->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $shamUsers->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'sham_users.destroy'])
            @endcomponent
        </div>
    </div>
@endsection