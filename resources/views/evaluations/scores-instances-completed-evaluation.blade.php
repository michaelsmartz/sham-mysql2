@extends('portal-index')
@section('title','Assess')
@section('modalTitle', 'Scores')

@section('postModalUrl', route('evaluations.pdfscores', array('evaluations.pdfscores', $Evaluationid,$AssessorName)))

@section('modalFooter')
    <div class="modal-footer">
        <div class="form-group">
            {!! Form::submit('Close',['class'=>'btn bg-gold b-r4 text-white has-spinner']) !!}
        </div>
    </div>
@endsection

@section('modalContent')
    <div class="modal-body">

        <div class="row">
            <div class="col-sm-2"><p><b>User: </b></p></div>
            <div class="col-sm-10">{{ isset($HeaderDetails) && key_exists("user",$HeaderDetails) ? $HeaderDetails['user'] : ' ' }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2"><p><b>Asessor Name: </b></p></div>
            <div class="col-sm-4">{{$AssessorName}}</div>
            <div class="col-sm-2"><p><b>Assessment: </b></p></div>
            <div class="col-sm-4">{{ isset($HeaderDetails) && key_exists("assessment",$HeaderDetails) ? $HeaderDetails['assessment'] : ' ' }}</div>
        </div>
        <div class="row">
            <div class="col-sm-2"><p><b>Department: </b></p></div>
            <div class="col-sm-4">{{ isset($HeaderDetails) && key_exists("department",$HeaderDetails) ? $HeaderDetails['department'] : ' ' }}</div>
            <div class="col-sm-2"><p><b>Reference No: </b></p></div>
            <div class="col-sm-4">{{ isset($HeaderDetails) && key_exists("referenceno",$HeaderDetails) ? $HeaderDetails['referenceno'] : ' ' }}</div>
        </div>
        <div class="row">
            <div class="col-sm-2"><p><b>Reference Source: </b></p></div>
            <div class="col-sm-4">{{ isset($HeaderDetails) && key_exists("referencesource",$HeaderDetails) ? $HeaderDetails['referencesource'] : ' ' }}</div>
            <div class="col-sm-2"><p><b>Feedback Date: </b></p></div>
            <div class="col-sm-4">{{ isset($HeaderDetails) && key_exists("feedbackdate",$HeaderDetails) ? $HeaderDetails['feedbackdate'] : ' ' }}</div>
        </div>

        <br>


        <div id="questionaireform">
            <div id="form">
                {!!  (isset($Content)?$Content:"") !!}
            </div>

            <div class="form-group">
                {!! Form::label('Comments',' Comments:') !!}
                {!! Form::textarea('Comments',$Comments,['class'=>'form-control', 'rows' => 3,'autocomplete'=>'off', 'placeholder'=>' Comment']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('Summary',' Summary:') !!}
                {!! Form::textarea('Summary',$Summary,['class'=>'form-control','rows' => 3, 'autocomplete'=>'off', 'placeholder'=>' Summary']) !!}
            </div>

        </div>



        <div id="questionairescore">

            <div class="form-group">
                <h4>Assessment Score: <span class = "badge">{{$MandatoryQuestionComment}}%</span> | Possible Score: <span class = "badge">{{$AssessmentScore}}%</span></h4>
            </div>

            <div class="panel panel-primary filterable">
                <div class="panel-heading">
                    <h3 class="panel-title">Scores</h3>
                </div>
                <table class="table table-striped tablesorter">
                    <thead>
                    <tr class="filters">
                        <th>Category</th>
                        <th>Expected Score</th>
                        <th>Actual Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($AssessmentDetails))
                        @foreach($AssessmentDetails as $AssessmentDetail)
                            <tr>
                                <td>{{$AssessmentDetail['Name']}}</td>
                                <td>{{$AssessmentDetail['Threshold']}}</td>
                                <td>{{$AssessmentDetail['TotalScores']}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{route('evaluations.pdfscores', array('evaluations.pdfscores', $Evaluationid,$AssessorName))}}" id="score_instances_form" name="score_instances_form" accept-charset="UTF-8" >
        {!! Form::hidden('htmlnode',null,['id'=>'htmlnode1']) !!}
        {!! Form::hidden('htmlnodeScore',null,['id'=>'htmlnodeScore']) !!}
        @yield('modalContent')
        @yield('modalFooter')
        </div>
    </form>
@endsection

@section("post-body")
    <script>

        $('input[type="text"], textarea').attr('readonly','readonly');

        $('.file-download').click(function() {

            var id =  $(this).closest('tr').data("id");
            window.location = '{{url()->current()}}/'+id;

        });
        $('.file-remove').click(function() {

            var id =  $(this).closest('tr').data("id");
            $('#md-content').load('{{url()->current()}}/'+id, {'_token':'{!! csrf_token() !!}'} );
        });


        $('.pdf-download').click(function() {

            var htmlnode =  $('#questionaireform').html();
            var htmlscore = $('#questionairescore').html();
            if (htmlnode)
            {
                $('#htmlnode1').val(htmlnode);
                $('#htmlnodeScore').val(htmlscore);
            }
        });

    </script>
@endsection
