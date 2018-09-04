@extends('portal-index')
@section('title','Compliance')
@section('subtitle', 'Share compliance documents with your employees')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">Laws</a></li>
        <li ><a href="{{URL::to('/')}}/policies">Policies</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($laws) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($laws) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new law</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Main Heading</th>
                            <th data-sortable="true">Sub Heading</th>
                            <th data-sortable="true">Country</th>
                            <th data-sortable="true">Law Category</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laws as $law)
                        <tr id="tr{{$law->id}}" data-id='{{$law->id}}'>
                            <td>{{ $law->main_heading }}</td>
                            <td>{{ $law->sub_heading }}</td>
                            <td>{{  isset($law->country->description) ? $law->country->description : ''  }}</td>
                            <td>{{  isset($law->lawCategory->description) ? $law->lawCategory->description : ''  }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#modal-text" class="b-n b-n-r bg-transparent item-edit" data-wenk="Edit" onclick="editForm('{{$law->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <a href="#modal-attachment" class="b-n b-n-r bg-transparent item-attachment"
                                            data-wenk="Attach Files"
                                            onclick="attachForm($(this).closest('tr').data('id'), event)">
                                        <i class="glyphicon glyphicon-paperclip text-primary"></i>
                                    </a>
                                    <a href="#!" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$law->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $laws->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'laws.destroy'])
            @endcomponent
        </div>
    </div>
@endsection