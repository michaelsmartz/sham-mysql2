@extends('portal-index')
@section('title','Evaluations')
@section('content')
    <div class="flex-wrapper">
        <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation" style="height:170px">
            <form action="" class="">
                <ul style="margin-left:0;padding-left:0" class="list-unstyled">
                    <li>
                        <input type="hidden" name="name" class="submitable-column-name" id="submitable-column-name" value="">
                        <div class="table-search-form">
                            <input type="search" name="search-term" value="{{old('search-term', null)}}" placeholder="Search" class="search-input" data-mirror="#submitable-column-name">
                            <div class="search-option">
                                <button type="submit" data-wenk="Do the Search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{route('evaluations.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="table-search-form" style="height:50px">
                            <button type="button" class="search-column-chooser-btn">
                                <p class="search-small">Search by</p>
                                <p class="search-large">Name</p>
                            </button>
                        </div>
                        <ul class="search-column-list">
                            <li data-filter-column="name">By Name<i class="fa fa-question-circle" data-wenk="Search on First Name/Surname"></i></li>
                            <li data-filter-column="assessment:name">By Assessment Name</li>
                            <li data-filter-column="department:description">By Department</li>
                            <li data-filter-column="reference_source">By Reference Source</li>
                            <li data-filter-column="reference_no">By Reference No</li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        <div id="table-container">
            @if(count($evaluations) > 0)
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
            @if(count($evaluations) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new evaluation</h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Assessment</th>
                            <th data-sortable="true">Employee</th>
                            <th data-sortable="true">Department</th>
                            <th data-sortable="true">Feedback Date</th>
                            <th data-sortable="true">Evaluation Status</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluations as $evaluation)
                        <tr id="tr{{$evaluation->id}}">
                                                        <td>{{ optional($evaluation->assessment)->name }}</td>
                            <td>{{ optional($evaluation->useremployee)->full_name }}</td>
                            <td>{{ optional($evaluation->department)->description }}</td>
                            <td>{{ $evaluation->feedback_date }}</td>
                            <td>{{ optional($evaluation->evaluationStatus)->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                        <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editFullPage('{{$evaluation->id}}', event)">
                                            <i class="glyphicon glyphicon-edit text-primary"></i>
                                        </a>
                                    @endif
                                    @if($allowedActions->contains('Delete'))
                                        <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$evaluation->id}}')">
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
                    {!! $evaluations->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'evaluations.destroy'])
            @endcomponent
        </div>
    </div>

    <div id="myModal1" class="modal fade">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p id="error"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>

        </div>
    </div>

    <div id="myModal" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Evaluation</h4>
                </div>
                <div class="modal-body">
                    <p><i class="glyphicon glyphicon-info-sign"></i> Please complete evaluation.</p>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-check"></span> Ok</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dalog -->
    </div><!-- /.modal -->


@endsection
@section('post-body')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        $('document').ready(function(){

            var evaluationassessorid = '{{session()->has('EvaluationAssessorId')?session('EvaluationAssessorId'):-1}}';
            var evaluationid = '{{session()->has('EvaluationId')?session('EvaluationId'):-1}}';

            if(evaluationassessorid > 0 && evaluationid > 0)
            {
                $("#myModal").modal('show');
                window.location =  "{{url()->to('evaluations')}}/"+evaluationassessorid+"/EvaluationId/"+evaluationid+"/assess";
            }
        });
    </script>

@endsection