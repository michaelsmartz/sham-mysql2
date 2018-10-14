@extends('portal-index')
@section('title','Category Questions')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($categoryQuestions) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($categoryQuestions) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new category question</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Title</th>
                            <th data-sortable="true">Question Type</th>
                            <th data-sortable="true">Points</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryQuestions as $categoryQuestion)
                        <tr id="tr{{$categoryQuestion->id}}">
                                                        <td>{{ $categoryQuestion->title }}</td>
                            <td>{{ optional($categoryQuestion->categoryQuestionType)->description }}</td>
                            <td>{{ $categoryQuestion->points }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editFullPage('{{$categoryQuestion->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$categoryQuestion->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $categoryQuestions->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'category_questions.destroy'])
            @endcomponent
        </div>
    </div>
@endsection