@extends('portal-index')
@section('title','Announcements')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($announcements) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($announcements) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new announcement</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Title</th>
                            <th data-sortable="true">Description</th>
                            <th data-sortable="true">Start Date</th>
                            <th data-sortable="true">End Date</th>
                            <th data-sortable="true">Status</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $announcement)
                        <tr id="tr{{$announcement->id}}">
                            <td>{{ $announcement->title }}</td>
                            <td>{{ $announcement->description }}</td>
                            <td>{{ $announcement->start_date }}</td>
                            <td>{{ $announcement->end_date }}</td>
                            <td>{!! App\Enums\AnnouncementType::getDescription($announcement->announcement_status_id) == 'Enabled' ? '<span class="badge badge-info">Enabled</span>' : '<span class="badge badge-default">Disabled</span>' !!}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$announcement->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$announcement->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $announcements->appends(request()->query())->links() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'announcements.destroy'])
            @endcomponent
        </div>
    </div>
@endsection