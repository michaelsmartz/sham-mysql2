@if((isset($evaluation))&& $evaluation->hasAnyAssessorComplete())
    <div class="alert alert-danger" style="margin-bottom: 0px;">
        <p>This Evaluation is partly completed and cannot be edited.</p>
    </div>
    <br>
@endif
<div class="row">
    
    <div class="form-group col-xs-12 {{ $errors->has('assessment_id') ? 'has-error' : '' }}">
        <label for="assessment_id">Assessment</label>
            <select class="form-control" id="assessment_id" name="assessment_id" required="true">
                    <option value="" style="display: none;" {{ old('assessment_id', optional($evaluation)->assessment_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select assessment</option>
                @foreach ($assessments as $key => $assessment)
                    <option value="{{ $key }}" {{ old('assessment_id', optional($evaluation)->assessment_id) == $key ? 'selected' : '' }}>
                        {{ $assessment }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('assessment_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('user_employee_id') ? 'has-error' : '' }}">
        <label for="user_employee_id">Employee</label>
            <select class="form-control" id="user_employee_id" name="user_employee_id" required="true">
                    <option value="" style="display: none;" {{ old('user_employee_id', optional($evaluation)->user_employee_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user employee</option>
                @foreach ($employees as $key => $employee)
                    <option value="{{ $key }}" {{ old('user_employee_id', optional($evaluation)->user_employee_id) == $key ? 'selected' : '' }}>
                        {{ $employee }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('user_employee_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('department_id') ? 'has-error' : '' }}">
        <label for="department_id">Department</label>
            <select class="form-control" id="department_id" name="department_id" required="true">
                    <option value="" style="display: none;" {{ old('department_id', optional($evaluation)->department_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select department</option>
                @foreach ($departments as $key => $department)
                    <option value="{{ $key }}" {{ old('department_id', optional($evaluation)->department_id) == $key ? 'selected' : '' }}>
                        {{ $department }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('department_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('reference_no') ? 'has-error' : '' }}">
        <label for="reference_no">Reference No</label>
            <input class="form-control" name="reference_no" type="text" id="reference_no" value="{{ old('reference_no', optional($evaluation)->reference_no) }}" maxlength="200" placeholder="Enter reference no">
            {!! $errors->first('reference_no', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('reference_source') ? 'has-error' : '' }}">
        <label for="reference_source">Reference Source</label>
            <input class="form-control" name="reference_source" type="text" id="reference_source" value="{{ old('reference_source', optional($evaluation)->reference_source) }}" maxlength="200" placeholder="Enter reference source">
            {!! $errors->first('reference_source', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('productcategory_id') ? 'has-error' : '' }}">
        <label for="productcategory_id">Product category</label>
            <select class="form-control" id="productcategory_id" name="productcategory_id" required="true">
                    <option value="" style="display: none;" {{ old('productcategory_id', optional($evaluation)->productcategory_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select product category</option>
                @foreach ($productCategories as $key => $productCategory)
                    <option value="{{ $key }}" {{ old('productcategory_id', optional($evaluation)->productcategory_id) == $key ? 'selected' : '' }}>
                        {{ $productCategory }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('productcategory_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('language_id') ? 'has-error' : '' }}">
        <label for="language_id">Language</label>
            <select class="form-control" id="language_id" name="language_id" required="true">
                    <option value="" style="display: none;" {{ old('language_id', optional($evaluation)->language_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter language</option>
                @foreach ($languages as $key => $language)
                    <option value="{{ $key }}" {{ old('language_id', optional($evaluation)->language_id) == $key ? 'selected' : '' }}>
                        {{ $language }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('language_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('feedback_date') ? 'has-error' : '' }}">
        <label for="feedback_date">Feedback Date</label>
            <input class="form-control datepicker" name="feedback_date" type="text" id="feedback_date" value="{{ isset($feedbackdate)? $feedbackdate:old('feedback_date', optional($evaluation)->feedback_date)}}" minlength="1" required="true" placeholder="Enter feedback date" >
            {!! $errors->first('feedback_date', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('evaluation_status_id') ? 'has-error' : '' }}">
        <label for="evaluation_status_id">Evaluation Status</label>
        <select class="form-control readonly" id="evaluation_status_id" name="evaluation_status_id" required="true" disabled>
            <option value="" style="display: none;" {{ old('evaluation_status_id', optional($evaluation)->evaluation_status_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select evaluation status</option>
            @foreach ($evaluationStatuses as $key => $evaluationStatus)
                <option value="{{ $key }}" {{ old('evaluation_status_id', optional($evaluation)->evaluation_status_id) == $key || ($mode == 'create' && $key == 1)? 'selected' : '' }}>
                    {{ $evaluationStatus }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('evaluation_status_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('comments') ? 'has-error' : '' }}">
        <label for="comments">Comments</label>
        <input class="form-control" name="comments" type="text" id="comments" value="{{ old('comments', optional($evaluation)->comments) }}" maxlength="512" placeholder="Enter comments">
        {!! $errors->first('comments', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<hr style="border-color: #2a88bd">
<div class="row">
    <div>
        <div class="form-group col-xs-12">
            {{ Form::label('QA Sample','QA Sample',array('id'=>'','class'=>'')) }}
            {{ Form::radio('status','savecontent',true,['id'=>'savecontent']) }} Upload Sample File
            {{ Form::radio('status','savepath',false,['id'=>'savepath']) }} Save Path Only
            {{ Form::radio('status','chatsaudio',false,['id'=>'chatsaudio']) }} SmartzChats Audio
        </div>

        <div id="contentcontainer">
            <?php if ($mode == 'edit'): ?>
            <div class="form-group col-xs-12">
                {!! Form::label('SameAudio','Replace Audio File:') !!}
                {!! Form::checkbox('SameAudio','true',null,($mode =='view')?['disabled']:['id'=>'SameAudio']) !!}
            </div>
            <?php endif; ?>
            <div class="form-group col-xs-12">
                {!! Form::label('QaSample','Audio File New:') !!}
                {{ Form::file('attachment', ($mode =='view')?['class'=>'form-control','disabled']:['class'=>'form-control bg-whitesmoke','accept'=>'audio/*', 'autocomplete'=>'off', 'placeholder'=>'Audio File', 'id'=>'attachment', 'required'=>"true"]) }}
            </div>
        </div>
        <div class="form-group col-xs-12" id="filecontainer">
                {{ Form::label('QA File Path','QA File Path',array('id'=>'','class'=>'')) }}
                {!! Form::text('url_path', old('url_path', optional($evaluation)->url_path),($mode =='view')?['class'=>'form-control','disabled']:['class'=>'form-control bg-whitesmoke', 'autocomplete'=>'off', 'placeholder'=>'QA File Path', 'id'=>'UrlPath']) !!}
        </div>

        <div id="smartzchatcontainer">
            <div class="col-sm-3">
                <div class="input-group input-group-sm">
                    {!! Form::text('filename', old('filename', optional($evaluation)->url_path),($mode =='view')?['class'=>'form-control','disabled']:['class'=>'form-control bg-whitesmoke', 'autocomplete'=>'off', 'placeholder'=>'Filename', 'id'=>'smartzrecordingreference']) !!}
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#myModal">Search</button>
                      </span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr style="border-color: #2a88bd">
<div class="row">
    <div class="col-xs-5">
        <Strong>Assessors</Strong>
    </div>
    <div class="col-xs-2">
    </div>
    <div class="col-xs-5">
        <Strong>Selected Assessors</Strong>
    </div>

</div>

<div class="row">

    <div class="form-group col-xs-12" style="padding-top: 5px;">
        <div class="flex-wrapper">
            <div class="col-xs-5" style="padding-left: 0px;">
                {!! Form::select('from[]', $employees, null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control multipleSelect', 'id'=>'multiselect')) !!}
            </div>
            <div class="col-xs-2">
                <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
            </div>
            <div class="col-xs-5" style="padding-right: 0px;">
                {!! Form::select('selectedassessors[]', isset($selectecAssessors)?$selectecAssessors:[],null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control', 'id'=>'multiselect_to')) !!}
            </div>
            {!! $errors->first('selectedassessors[]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    @if($mode == 'create')
        <div class="col-xs-12 pull-left">
            <div class="checkbox">
                <label><input type="checkbox" name="selectedemployee" value="1">Add selected employee and you as assessor</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" name="linemanager" value="1">Add line manager as assessor</label>
            </div>
        </div>
    @endif

</div>
<br>

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Smartz Chats Audio</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-7">
                        <div class="input-group input-group-sm">
                            {!! Form::text('audiodate', null,($mode =='view')?['class'=>'form-control','disabled']:['class'=>'form-control bg-whitesmoke', 'autocomplete'=>'off', 'placeholder'=>'Choose Date', 'id'=>'recordingdate']) !!}
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-sm" type="button" id="searchaudio">Search</button>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12" style="overflow: auto;">
                        <table class="table table-striped table-bordered table-hover" id="datatable">
                            <tr>
                                <th>Filename</th>
                                <th>Disposition</th>
                                <th>Duration</th>
                                <th>use</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="selectAudioFromModal" name="selectAudioFromModal">Select</button>
            </div>
        </div>
    </div>
</div>

@component('partials.index')
@endcomponent

@section('post-body')

    <script src="{{url('/')}}/js/tables.min.js"></script>
    <script src="{{url('/')}}/plugins/multiselect/multiselect.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>

        $(function () {
            $('#multiselect').each(function(){
                $(this).multiselect({
                    submitAllLeft:false,
                    sort: false,
                    keepRenderingSort: false,
                    search: {
                        left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                        right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                    },
                    fireSearch: function(value) {
                        return value.length > 3;
                    }
                });
            });

        });
    </script>
    <script>

        $("#user_employee_id").change(function () {

            var empid = $('#user_employee_id').val();
            $.getJSON("{{URL::to('/')}}/employees/"+empid+"/departmentid", function (json) {
                var departmentid;

                departmentid = json.department_id;
                // set selected countries from form data

                if (departmentid!='') {
                    $('#department_id').val(departmentid);
                    //$multiSelect.val(DepartmentId).trigger("change");
                }
                else
                {
                    $('#department_id').val(0);
                }
            });
        });

        $('#savepath').click(function() {

            $('#contentcontainer').slideUp(300);
            $('#smartzchatcontainer').slideUp(300);
            $('#filecontainer').slideDown(300);
            $('#UrlPath').prop("required",true);
            $('#attachment').prop("required",false);
            $('#smartzrecordingreference').prop("required",false);
        });

        $('#savecontent').click(function() {
            $('#contentcontainer').slideDown(300);
            $('#smartzchatcontainer').slideUp(300);
            $('#filecontainer').slideUp(300);

            mode = '{{$mode}}';
            $('#UrlPath').prop("required",false);
            $('#smartzrecordingreference').prop("required",false);
            if(mode == 'create')
            {
               $('#attachment').prop("required",true);
            }
        });

        $('#chatsaudio').click(function() {

            $('#contentcontainer').slideUp(300);
            $('#filecontainer').slideUp(300);
            $('#smartzchatcontainer').slideDown(300);

            $('#smartzrecordingreference').prop("required",true);
            $('#UrlPath').prop("required",false);
            $('#attachment').prop("required",false);
        });

        $(document).ready(function(){
            var recordingfilereference;
            mode = '{{$mode}}';
            //alert(mode);
            if(mode == 'create')
            {
                //$('#QaSample').addClass("required");
                $( "#savecontent" ).click();
            }

            $("#searchaudio").click(function(){

                var data = {"apiUsername": "Development", "apiPassword" : "D3velop%m3Nt", "dateFrom": "2018-10-01","dateTo":"2018-11-04"};
                $.post("https://chats-development.smartz-solutions.com/APIV1/CallRecords", data, function(result){
                    //$("span").html(result);
                    //console.log(result);

                    $('#datatable tr').not(':first').not(':last').remove();
                    var html = '';
                    for(var i = 0; i < result.length; i++){

                        if(result[i].recording_filename.length > 0){
                            var dateofrecording = result[i].call_start_date.split(' ')[0];
                            html += '<tr>'+
                                    '<td class="recordingfile">' + dateofrecording + '/' +result[i].recording_filename + '</td>' +
                                    '<td>' + result[i].disposition + '</td>' +
                                    '<td>' + result[i].duration + '</td>' +
                                    '<td> <input type="radio"  value="1" name="selectedaudio" /></label> </td>' +
                                    '</tr>';
                        }
                    }
                    $('#datatable tr').first().after(html);
                })
            });

            $("#selectAudioFromModal").click(function(){
                console.log('Test');
                $("#smartzrecordingreference").val(recordingfilereference);
                $('#myModal').modal("hide");
            });


            $("#datatable").on('click', "input[name=selectedaudio]:radio", function() {
                recordingfilereference = $(this).closest('tr').find('.recordingfile').text();
            });

            if(mode == 'edit')
            {
                usecontent = '{{(isset($evaluation->is_usecontent))?$evaluation->is_usecontent:-1 }}' ;
                $( "#QaSample" ).prop('disabled', true);
                if(usecontent == "1")
                {
                    $( "#savecontent" ).click();
                }
                else if(usecontent == "-1"){

                }
                if(usecontent == "2")
                {
                    $( "#chatsaudio" ).click();
                }
                else {
                    $( "#savepath" ).click();
                }
            }
        });
    </script>
    <style>

        .modal-body{
            height: 350px;
            overflow-y: auto;
        }
    </style>
@endsection
