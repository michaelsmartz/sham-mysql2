@extends('portal-index')
@section('title','Instances')

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
                                <a href="{{route('evaluations.instances')}}" role="button" data-wenk="Reset all Criteria & reload the list">
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
                    </div>
                </div>
            @endif

            <div class="table-responsive">
                @if(count($evaluations) == 0)
                    <h4 class="text-center"></h4>
                @elseif($allowedActions->contains('List'))
                    <table id="table" data-toggle="table" data-detail-view="true">
                        <thead>
                        <tr>
                            <th data-sortable="true">Assessment</th>
                            <th data-sortable="true">Employee</th>
                            <th data-sortable="true">Department</th>
                            <th data-sortable="true">Feedback Date</th>
                            <th data-sortable="true">Evaluation Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $counter = 0;
                        ?>
                        @foreach($evaluations as $evaluation)
                            <?php
                            $counter =  $counter+1;
                            ?>
                            <tr class="clickable-row"  id="tr{{$evaluation->id}}" data-id="{{$evaluation->id}}"  data-url="{{URL::to('/evaluations')}}">
                                <td>{{ optional($evaluation->assessment)->name }}</td>
                                <td>{{ optional($evaluation->employee)->full_name }}</td>
                                <td>{{ optional($evaluation->department)->description }}</td>
                                <td>{{ $evaluation->feedback_date }}</td>
                                <td>{!! App\Enums\EvaluationStatusType::getDescription($evaluation->evaluation_status_id) !!}</td>
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

    <div id="md" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="true" >
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div id="md-content" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Scores</h4>
                </div>
                <div class="modal-body">
                      <span>
                        <div id="loading" style="width:2px;height:2px; display:none;">
                            <img src="{{url('/images/loading_32.gif')}}" style="margin-top:-22px;padding-left: 2px;">
                        </div>
                      </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gold b-r4 text-white has-spinner" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script>

        $(document).ready(function(){
            $('#loading').css({'display': 'block', 'width':'2px', 'height':'2px'});
            var $table = $('#table');

            $table.find('tr td:first-child').each(function () {
                $(this).children('a.detail-icon').children('i.glyphicon.glyphicon-plus.icon-plus').attr('data-wenk', 'Show Assessors');
                $(this).children('a.detail-icon').children('i.glyphicon.glyphicon-plus.icon-plus').attr('data-wenk-pos', 'right');
                //alert('row');
            });
            //alert('Document Ready');
        });

        var assessorId = '{{session()->has('Id')?session('Id'):-1}}';
        var evaluationId = '{{session()->has('EvaluationId')?session('EvaluationId'):-1}}';
        if(assessorId > 0)
        {
            $('#md-content').load('{{url()->to('evaluations')}}/'+assessorId+'/score/'+evaluationId+'/show-score-modal',function(response, status){
                if (status === "success"){
                    $('#md').modal('show');
                    $('#loading').css({'display': 'none'});
                }
            });
        }else{

        }

    </script>

    <style>
        .modal {
            display:block;
        }

        .modal-dialog {
            width: 1200px;
        }

        .modal-body{
            height: 500px;
            overflow-y: auto;
        }
    </style>
@endsection

