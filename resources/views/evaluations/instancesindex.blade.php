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

        [role="button"] {
            cursor: pointer;
        }
        .modal-open {
            overflow: hidden;
        }
        .modal {
            display: none;
            overflow: hidden;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1050;
            -webkit-overflow-scrolling: touch;
            outline: 0;
        }
        .modal.fade .modal-dialog {
            -webkit-transform: translate(0, -25%);
            -ms-transform: translate(0, -25%);
            -o-transform: translate(0, -25%);
            transform: translate(0, -25%);
            -webkit-transition: -webkit-transform 0.3s ease-out;
            -o-transition: -o-transform 0.3s ease-out;
            transition: transform 0.3s ease-out;
        }
        .modal.in .modal-dialog {
            -webkit-transform: translate(0, 0);
            -ms-transform: translate(0, 0);
            -o-transform: translate(0, 0);
            transform: translate(0, 0);
        }
        .modal-open .modal {
            overflow-x: hidden;
            overflow-y: auto;
        }
        .modal-dialog {
            position: relative;
            width: auto;
            margin: 10px;
        }
        .modal-content {
            position: relative;
            background-color: #ffffff;
            border: 1px solid #999999;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
            box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            outline: 0;
        }
        .modal-backdrop {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            background-color: #000000;
        }
        .modal-backdrop.fade {
            opacity: 0;
            filter: alpha(opacity=0);
        }
        .modal-backdrop.in {
            opacity: 0.5;
            filter: alpha(opacity=50);
        }
        .modal-header {
            padding: 15px;
            border-bottom: 1px solid #e5e5e5;
            min-height: 16.42857143px;
        }
        .modal-header .close {
            margin-top: -2px;
        }
        .modal-title {
            margin: 0;
            line-height: 1.42857143;
        }
        .modal-body {
            position: relative;
            padding: 15px;
        }
        .modal-footer {
            padding: 15px;
            text-align: right;
            border-top: 1px solid #e5e5e5;
        }
        .modal-footer .btn + .btn {
            margin-left: 5px;
            margin-bottom: 0;
        }
        .modal-footer .btn-group .btn + .btn {
            margin-left: -1px;
        }
        .modal-footer .btn-block + .btn-block {
            margin-left: 0;
        }
        .modal-scrollbar-measure {
            position: absolute;
            top: -9999px;
            width: 50px;
            height: 50px;
            overflow: scroll;
        }
        .close {
            float: right;
            font-size: 21px;
            font-weight: bold;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            filter: alpha(opacity=20);
            opacity: .2;
        }
        button.close {
            -webkit-appearance: none;
            padding: 0;
            cursor: pointer;
            background: transparent;
            border: 0;
        }
        .close:hover, .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
            filter: alpha(opacity=50);
            opacity: .5;
        }
        @media (min-width: 768px) {
            .modal-dialog {
                width: 600px;
                margin: 30px auto;
            }
            .modal-content {
                -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            }
            .modal-sm {
                width: 300px;
            }
        }
        @media (min-width: 992px) {
            .modal-lg {
                width: 900px;
            }
        }
        [role="button"] {
            cursor: pointer;
        }
        .btn {
            display: inline-block;
            margin-bottom: 0;
            font-weight: normal;
            text-align: center;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            border-radius: 4px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .btn:focus,
        .btn:active:focus,
        .btn.active:focus,
        .btn.focus,
        .btn:active.focus,
        .btn.active.focus {
            outline: thin dotted;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }
        .btn:hover,
        .btn:focus,
        .btn.focus {
            color: #333333;
            text-decoration: none;
        }
        .btn:active,
        .btn.active {
            outline: 0;
            background-image: none;
            -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        }
        .btn.disabled,
        .btn[disabled],
        fieldset[disabled] .btn {
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.65;
            filter: alpha(opacity=65);
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .btn-default {
            color: #333333;
            background-color: #ffffff;
            border-color: #cccccc;
        }
        .btn-default:hover,
        .btn-default:focus,
        .btn-default.focus,
        .btn-default:active,
        .btn-default.active,
        .open > .dropdown-toggle.btn-default {
            color: #333333;
            background-color: #e6e6e6;
            border-color: #adadad;
        }
        .btn-default:active,
        .btn-default.active,
        .open > .dropdown-toggle.btn-default {
            background-image: none;
        }
        .btn-default.disabled,
        .btn-default[disabled],
        fieldset[disabled] .btn-default,
        .btn-default.disabled:hover,
        .btn-default[disabled]:hover,
        fieldset[disabled] .btn-default:hover,
        .btn-default.disabled:focus,
        .btn-default[disabled]:focus,
        fieldset[disabled] .btn-default:focus,
        .btn-default.disabled.focus,
        .btn-default[disabled].focus,
        fieldset[disabled] .btn-default.focus,
        .btn-default.disabled:active,
        .btn-default[disabled]:active,
        fieldset[disabled] .btn-default:active,
        .btn-default.disabled.active,
        .btn-default[disabled].active,
        fieldset[disabled] .btn-default.active {
            background-color: #ffffff;
            border-color: #cccccc;
        }
        .btn-default .badge {
            color: #ffffff;
            background-color: #333333;
        }
        .btn-primary {
            color: #ffffff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary.focus,
        .btn-primary:active,
        .btn-primary.active,
        .open > .dropdown-toggle.btn-primary {
            color: #ffffff;
            background-color: #286090;
            border-color: #204d74;
        }
        .btn-primary:active,
        .btn-primary.active,
        .open > .dropdown-toggle.btn-primary {
            background-image: none;
        }
        .btn-primary.disabled,
        .btn-primary[disabled],
        fieldset[disabled] .btn-primary,
        .btn-primary.disabled:hover,
        .btn-primary[disabled]:hover,
        fieldset[disabled] .btn-primary:hover,
        .btn-primary.disabled:focus,
        .btn-primary[disabled]:focus,
        fieldset[disabled] .btn-primary:focus,
        .btn-primary.disabled.focus,
        .btn-primary[disabled].focus,
        fieldset[disabled] .btn-primary.focus,
        .btn-primary.disabled:active,
        .btn-primary[disabled]:active,
        fieldset[disabled] .btn-primary:active,
        .btn-primary.disabled.active,
        .btn-primary[disabled].active,
        fieldset[disabled] .btn-primary.active {
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        .btn-primary .badge {
            color: #337ab7;
            background-color: #ffffff;
        }
        .btn-success {
            color: #ffffff;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }
        .btn-success:hover,
        .btn-success:focus,
        .btn-success.focus,
        .btn-success:active,
        .btn-success.active,
        .open > .dropdown-toggle.btn-success {
            color: #ffffff;
            background-color: #449d44;
            border-color: #398439;
        }
        .btn-success:active,
        .btn-success.active,
        .open > .dropdown-toggle.btn-success {
            background-image: none;
        }
        .btn-success.disabled,
        .btn-success[disabled],
        fieldset[disabled] .btn-success,
        .btn-success.disabled:hover,
        .btn-success[disabled]:hover,
        fieldset[disabled] .btn-success:hover,
        .btn-success.disabled:focus,
        .btn-success[disabled]:focus,
        fieldset[disabled] .btn-success:focus,
        .btn-success.disabled.focus,
        .btn-success[disabled].focus,
        fieldset[disabled] .btn-success.focus,
        .btn-success.disabled:active,
        .btn-success[disabled]:active,
        fieldset[disabled] .btn-success:active,
        .btn-success.disabled.active,
        .btn-success[disabled].active,
        fieldset[disabled] .btn-success.active {
            background-color: #5cb85c;
            border-color: #4cae4c;
        }
        .btn-success .badge {
            color: #5cb85c;
            background-color: #ffffff;
        }
        .btn-info {
            color: #ffffff;
            background-color: #5bc0de;
            border-color: #46b8da;
        }
        .btn-info:hover,
        .btn-info:focus,
        .btn-info.focus,
        .btn-info:active,
        .btn-info.active,
        .open > .dropdown-toggle.btn-info {
            color: #ffffff;
            background-color: #31b0d5;
            border-color: #269abc;
        }
        .btn-info:active,
        .btn-info.active,
        .open > .dropdown-toggle.btn-info {
            background-image: none;
        }
        .btn-info.disabled,
        .btn-info[disabled],
        fieldset[disabled] .btn-info,
        .btn-info.disabled:hover,
        .btn-info[disabled]:hover,
        fieldset[disabled] .btn-info:hover,
        .btn-info.disabled:focus,
        .btn-info[disabled]:focus,
        fieldset[disabled] .btn-info:focus,
        .btn-info.disabled.focus,
        .btn-info[disabled].focus,
        fieldset[disabled] .btn-info.focus,
        .btn-info.disabled:active,
        .btn-info[disabled]:active,
        fieldset[disabled] .btn-info:active,
        .btn-info.disabled.active,
        .btn-info[disabled].active,
        fieldset[disabled] .btn-info.active {
            background-color: #5bc0de;
            border-color: #46b8da;
        }
        .btn-info .badge {
            color: #5bc0de;
            background-color: #ffffff;
        }
        .btn-warning {
            color: #ffffff;
            background-color: #f0ad4e;
            border-color: #eea236;
        }
        .btn-warning:hover,
        .btn-warning:focus,
        .btn-warning.focus,
        .btn-warning:active,
        .btn-warning.active,
        .open > .dropdown-toggle.btn-warning {
            color: #ffffff;
            background-color: #ec971f;
            border-color: #d58512;
        }
        .btn-warning:active,
        .btn-warning.active,
        .open > .dropdown-toggle.btn-warning {
            background-image: none;
        }
        .btn-warning.disabled,
        .btn-warning[disabled],
        fieldset[disabled] .btn-warning,
        .btn-warning.disabled:hover,
        .btn-warning[disabled]:hover,
        fieldset[disabled] .btn-warning:hover,
        .btn-warning.disabled:focus,
        .btn-warning[disabled]:focus,
        fieldset[disabled] .btn-warning:focus,
        .btn-warning.disabled.focus,
        .btn-warning[disabled].focus,
        fieldset[disabled] .btn-warning.focus,
        .btn-warning.disabled:active,
        .btn-warning[disabled]:active,
        fieldset[disabled] .btn-warning:active,
        .btn-warning.disabled.active,
        .btn-warning[disabled].active,
        fieldset[disabled] .btn-warning.active {
            background-color: #f0ad4e;
            border-color: #eea236;
        }
        .btn-warning .badge {
            color: #f0ad4e;
            background-color: #ffffff;
        }
        .btn-danger {
            color: #ffffff;
            background-color: #d9534f;
            border-color: #d43f3a;
        }
        .btn-danger:hover,
        .btn-danger:focus,
        .btn-danger.focus,
        .btn-danger:active,
        .btn-danger.active,
        .open > .dropdown-toggle.btn-danger {
            color: #ffffff;
            background-color: #c9302c;
            border-color: #ac2925;
        }
        .btn-danger:active,
        .btn-danger.active,
        .open > .dropdown-toggle.btn-danger {
            background-image: none;
        }
        .btn-danger.disabled,
        .btn-danger[disabled],
        fieldset[disabled] .btn-danger,
        .btn-danger.disabled:hover,
        .btn-danger[disabled]:hover,
        fieldset[disabled] .btn-danger:hover,
        .btn-danger.disabled:focus,
        .btn-danger[disabled]:focus,
        fieldset[disabled] .btn-danger:focus,
        .btn-danger.disabled.focus,
        .btn-danger[disabled].focus,
        fieldset[disabled] .btn-danger.focus,
        .btn-danger.disabled:active,
        .btn-danger[disabled]:active,
        fieldset[disabled] .btn-danger:active,
        .btn-danger.disabled.active,
        .btn-danger[disabled].active,
        fieldset[disabled] .btn-danger.active {
            background-color: #d9534f;
            border-color: #d43f3a;
        }
        .btn-danger .badge {
            color: #d9534f;
            background-color: #ffffff;
        }
        .btn-link {
            color: #337ab7;
            font-weight: normal;
            border-radius: 0;
        }
        .btn-link,
        .btn-link:active,
        .btn-link.active,
        .btn-link[disabled],
        fieldset[disabled] .btn-link {
            background-color: transparent;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .btn-link,
        .btn-link:hover,
        .btn-link:focus,
        .btn-link:active {
            border-color: transparent;
        }
        .btn-link:hover,
        .btn-link:focus {
            color: #23527c;
            text-decoration: underline;
            background-color: transparent;
        }
        .btn-link[disabled]:hover,
        fieldset[disabled] .btn-link:hover,
        .btn-link[disabled]:focus,
        fieldset[disabled] .btn-link:focus {
            color: #777777;
            text-decoration: none;
        }
        .btn-lg {
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.3333333;
            border-radius: 6px;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
        .btn-xs {
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
        .btn-block {
            display: block;
            width: 100%;
        }
        .btn-block + .btn-block {
            margin-top: 5px;
        }
        input[type="submit"].btn-block,
        input[type="reset"].btn-block,
        input[type="button"].btn-block {
            width: 100%;
        }
        .clearfix:before,
        .clearfix:after,
        .modal-footer:before,
        .modal-footer:after {
            content: " ";
            display: table;
        }
        .clearfix:after,
        .modal-footer:after {
            clear: both;
        }
        .center-block {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .pull-right {
            float: right !important;
        }
        .pull-left {
            float: left !important;
        }
        .hide {
            display: none !important;
        }
        .show {
            display: block !important;
        }
        .invisible {
            visibility: hidden;
        }
        .text-hide {
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }
        .hidden {
            display: none !important;
        }
        .affix {
            position: fixed;
        }
    </style>
@endsection

