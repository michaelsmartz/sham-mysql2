@extends('portal-index')
@section('title','Report Templates')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($reportTemplates) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($reportTemplates) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new report template</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Source</th>
                            <th data-sortable="true">Title</th>
                            <th data-sortable="true">System Module</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportTemplates as $reportTemplate)
                        <tr id="tr{{$reportTemplate->id}}">
                                                        <td>{{ $reportTemplate->source }}</td>
                            <td>{{ $reportTemplate->title }}</td>
                            <td>{{ optional($reportTemplate->systemModule)->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$reportTemplate->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$reportTemplate->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $reportTemplates->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'report_templates.destroy'])
            @endcomponent
        </div>
    </div>
@endsection