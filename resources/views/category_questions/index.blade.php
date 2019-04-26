@extends('portal-index')
@section('title','Category Questions')
@section('content')
    <div class="flex-wrapper">
        <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation" style="height:170px">
            <form action="" class="">
                <ul style="margin-left:0;padding-left:0" class="list-unstyled">
                    <li>
                        <input type="hidden" name="title" class="submitable-column-name" id="submitable-column-name" value="">
                        <div class="table-search-form">
                            <input type="search" name="search-term" value="{{old('search-term', null)}}" placeholder="Search" class="search-input" data-mirror="#submitable-column-name">
                            <div class="search-option">
                                <button type="submit" data-wenk="Do the Search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{route('category_questions.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="table-search-form" style="height:50px">
                            <button type="button" class="search-column-chooser-btn">
                                <p class="search-small">Search by</p>
                                <p class="search-large">Title</p>
                            </button>
                        </div>
                        <ul class="search-column-list">
                            <li data-filter-column="title">By Title <i class="fa fa-question-circle" data-wenk="Search on First Name/Surname"></i></li>
                            <li data-filter-column="description">By Description</li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        <div id="table-container">
            @if(count($categoryQuestions) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    @if($allowedActions->contains('List'))
                        <button id="sidebarCollapse" class="btn btn-default" data-toggle="offcanvas">
                            <i class="glyphicon glyphicon-align-left"></i>
                            <span>Filters</span>
                        </button>
                    @endif
                    @if($allowedActions->contains('Create'))
                        <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                            <i class="glyphicon glyphicon-plus"></i> Add New
                        </button>
                    @endif
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($categoryQuestions) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new category question</h4>
            @elseif($allowedActions->contains('List'))
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
                            <td>{!! App\Enums\CategoryQuestionType::getDescription($categoryQuestion->category_question_type_id) !!}</td>
                            <td>{{ $categoryQuestion->points }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                        <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editFullPage('{{$categoryQuestion->id}}', event)">
                                            <i class="glyphicon glyphicon-edit text-primary"></i>
                                        </a>
                                    @endif
                                    @if($allowedActions->contains('Delete'))
                                        <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$categoryQuestion->id}}')">
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
                    {!! $categoryQuestions->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'category_questions.destroy'])
            @endcomponent
        </div>
    </div>
@endsection