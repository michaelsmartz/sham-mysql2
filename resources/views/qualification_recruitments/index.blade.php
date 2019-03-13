@extends('portal-index')
@section('title','Qualifications')
@section('subtitle','Qualification drop-down values for Recruitment Request')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/interviews">Interviews</a></li>
        <li class="active"><a href="#">Qualifications</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($qualificationRecruitments) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($qualificationRecruitments) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new qualification recruitment</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Description</th>
                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qualificationRecruitments as $qualificationRecruitment)
                        <tr id="tr{{$qualificationRecruitment->id}}">
                            <td>{{ $qualificationRecruitment->description }}</td>
                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$qualificationRecruitment->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$qualificationRecruitment->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $qualificationRecruitments->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'qualification-recruitments.destroy'])
            @endcomponent
        </div>
    </div>
@endsection