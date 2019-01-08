@extends('portal-index')
@section('title','Assess')
@section('content')

    <div class="">

        {!! Form::open(array('route' => array('evaluations.submit_assessment', $Id,$EvaluationId),'method'=>'POST', 'files'=>true,'data-jquery-validate'=>'true')) !!}


        <div class="">
            <div class="">
                <div class="hidden">
                    <input type="text" name="starttime" id ="starttime" ><br>
                    <!-- <input type="text" name="endtime" id="endtime" ><br> -->
                </div>
                <div>
                    <p><b>Employee Name: </b>{{$employeeDetails}}</p>
                    @if($usecontent == 1)
                        <p><b>Audio File: </b>
                            <button type="button" class="btn btn-default btn-sm file-download">Download</button>
                        </p>
                    @elseif($usecontent == 2)
                        <p><b>Audio File: </b></p>
                        <audio controls src="{!! (isset($audio)?$audio:"") !!}"></audio>
                    @else
                        <p><b>QA Sample: </b>{{$urlpath}}
                        </p>
                    @endif

                    <div class="form-group">
                        {!! Form::hidden('participants','yes') !!}
                    </div>
                </div>

                <!--<div style="height: 50%; overflow-y:scroll; position:fixed"> -->
                <div class="nicescroll-box" style="padding:10px;border-width: 1px; border-color: red; border-style: solid;">
                    <div class="wrap" style="height: 300px;">
                        <div id="form">
                            {!!  (isset($content)?$content:"") !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Summary',' Summary:') !!}
                            {!! Form::textarea('Summary',null,['class'=>'form-control','rows' => 3, 'autocomplete'=>'off', 'placeholder'=>' Summary']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Comments',' Comments:') !!}
                            {!! Form::textarea('Comments',null,['class'=>'form-control', 'rows' => 3,'autocomplete'=>'off', 'placeholder'=>' Comment']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="modal-footer">
            <div class="form-group">
                {!! Form::submit('Save',['class'=>'btn bg-gold b-r4 text-white has-spinner']) !!}
                <button type="button" class="btn btn-default bg-grey b-r4" onclick="history.back()">Cancel</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div id="myModal" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Error</h4>
                </div>
                <div class="modal-body">
                    <p id="errormsg"><i class="glyphicon glyphicon-info-sign"></i> Please complete evaluation.</p>
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

@section("post-body")
    <link href="{{URL::to('/')}}/css/nicescroll.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/jquery.nicescroll-3.6.8.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>

        $(document).ready(function () {
            $('#starttime').val('{{$startDateTime}}');

            $('form').submit(function(event) {

                try{
                    var check = true;

                    var questionnos = [];

                    $('input[type="checkbox"]').each(function(){
                        var name = $(this).attr("name");

                        //console.log($(this));
                        if($('input[type=checkbox][name="'+name+'"]:checked').length == 0){
                            check = false;
                            //$(this).parent().prev().css({"background-color": "yellow"});
                            var question =  $(this).parent().prev().find('label').text();
                            var questionno = question.substr(0, question.indexOf(' '));
                            questionnos.push(questionno);
                        }
                    });

                    $('input[type="radio"]').each(function(){
                        var name = $(this).attr("name");

                        //console.log($(this));
                        if($('input[type=radio][name="'+name+'"]:checked').length == 0){
                            check = false;
                            var question =  $(this).parent().prev().find('label').text();
                            var questionno = question.substr(0, question.indexOf(' '));
                            questionnos.push(questionno);
                        }
                    });

                    $('input[type="text"][name^="question_"]').each(function(){
                        var name = $(this).attr("name");

                        if($(this).val().trim().length == 0){
                            check = false;
                            var question =  $(this).prev().find('label').text();
                            var questionno = question.substr(0, question.indexOf(' '));
                            questionnos.push(questionno);
                        }
                    });

                    $.unique(questionnos.sort());
                    //alert("Please attempt question(s) "+ questionnos.join(", ") + " before saving.");

                    if(!check){
                        $("#errormsg").html("Please attempt question(s) "+ questionnos.join(", ") + " before saving.");
                        $("#myModal").modal('show');
                    }

                    return check;
                }

                catch(err)
                {
                    //console.log(err);
                    alert(err);
                    return false;
                }

       return false;
   });




});

$(function() {
   $(".wrap").niceScroll({cursorcolor:"#00F"});
   //$(".nicescroll-box").niceScroll({cursorcolor:"#00F"});
});

$('.file-download').click(function() {
   var evaluationid = {{$EvaluationId}};
            var mediaid = {{isset($mediaid)&& $mediaid !=null ?$mediaid:0}};
            window.location = '{{url()->to('evaluations')}}/'+evaluationid+'/attachment/'+mediaid;
        });
    </script>

@endsection
