@extends('portal-index')
@section('title','Category Question Types')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">Category Question Type</a></li>
        <li ><a href="{{URL::to('/')}}/product_categories">Product Categories</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($categoryQuestionTypes) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($categoryQuestionTypes) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new category question type</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Description</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryQuestionTypes as $categoryQuestionType)
                        <tr id="tr{{$categoryQuestionType->id}}">
                                                        <td>{{ $categoryQuestionType->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$categoryQuestionType->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$categoryQuestionType->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $categoryQuestionTypes->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'category_question_types.destroy'])
            @endcomponent
        </div>
    </div>
@endsection