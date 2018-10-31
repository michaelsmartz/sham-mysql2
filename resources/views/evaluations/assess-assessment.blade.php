@extends('portal-index')
@section('title','Assesss')
@section('content')
    <div class="flex-wrapper">

        {!! Form::open(array('route' => array('evaluations.submit_assessment', $Id,$EvaluationId),'method'=>'POST', 'files'=>true,'data-jquery-validate'=>'true')) !!}


        <div class="modal-body p-t0 p-r5">
            <div class="scrolled-content-wrapper">
                <div class="hidden">
                    <input type="text" name="starttime" id ="starttime" ><br>
                    <!-- <input type="text" name="endtime" id="endtime" ><br> -->
                </div>

                <p><b>Employee Name: </b>{{$employeeDetails}}</p>
                @if($usecontent)
                    <p><b>Audio File: </b>
                        <button type="button" class="btn btn-default btn-sm file-download">Download</button>
                    </p>
                @else
                    <p><b>QA Sample: </b>{{$urlpath}}
                    </p>
                @endif

                <div class="form-group">
                    {!! Form::hidden('participants','yes') !!}
                </div>

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
        <div class="modal-footer">
            <div class="form-group">
                {!! Form::submit('Save',['class'=>'btn bg-gold b-r4 text-white has-spinner']) !!}
                <button type="button" class="btn btn-default bg-grey b-r4" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section("post-body")
    <script>
        $(document).ready(function () {
            $('#starttime').val('{{$startDateTime}}');
        });
    </script>
@endsection
