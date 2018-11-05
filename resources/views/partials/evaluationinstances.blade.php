<style>
    .subcontent{
        /* width: 100%;*/
        overflow:auto;
        /* margin-top: 8px; */
        color:#2C2C2C;
        border-radius: 8px;
    }

    .subcontentYes {
        background-color: #B7FF5E;
    }

    .subcontentNo {
        background-color: #FF7F5F /*#EB5055*/;
    }
    .state-small {
        padding: 0em 4px;
        font-size: 12px;
        width: 73px;
    }
    .state-green {
        background-color: #B7FF5E;
    }
    .state-red {
        background-color: #FF7F5F;
    }
    .state{
        display: inline-block;
        /*padding: 4px 8px;*/
        /* font-weight: 600; */
        line-height: 20px;
        /*color: #fff;*/
        text-align: center;
        /* background-color: #6a737d;*/
        border-radius: 3px;
    }
    .collapse-row{
        border-color: red;
    }

</style>
<script>
    function assessForm(id,evaluationid,event) {
        window.location = '{{url()->to('evaluations')}}/'+id+'/EvaluationId/'+evaluationid+'/assess';
    }

    function assessorEditForm(id,evaluationid,event)
    {
        window.location = '{{url()->to('evaluations')}}/'+id+'/score/'+evaluationid+'/show';
    }

</script>
<div class="row">
    <div class="col-md-3" style="padding-left: 100px"><b>Assessor</b></div>
    <div class="col-md-2"><b>Completed</b></div>
    <div class="col-md-2"><b>Score</b></div>
    <div class="col-md-4"><b>Action</b></div>
</div>

@foreach($evaluationDetails->assessors as $assessor)
    <div class="row" style=" margin-top: -12px;">
        <div class="col-md-3" style="padding-left: 100px;">{{$assessor->full_name}}</div>
        <div class="col-md-2">
            @if($assessor->is_completed == '1')
                <span class="state state-small state-green">Yes</span>
            @else
                <span class="state state-small state-red">No</span>
            @endif
        </div>

        <div class="col-md-2">{{$assessor->overall_score}}</div>
        <div class="col-md-4" data-id="{{$assessor->id}}" data-evaluationid='{{$assessor->evaluation_id}}'  data-assessorid='{{$assessor->employee_id}}'>
            <button type="button" title="Review" class="b-n b-n-r bg-transparent  item-summary tooltips" onclick="summaryForm($(this).closest('div').data('id'),$(this).closest('div').data('evaluationid'),$(this).closest('div').data('assessorid'), event)"><i class="glyphicon glyphicon-blackboard text-bootstrap-primary"></i></button>
            <button type="button" title="Score" class="b-n b-n-r bg-transparent item-assessoredit tooltips" onclick="assessorEditForm($(this).closest('div').data('id'), $(this).closest('div').data('evaluationid'), event)"><i class="glyphicon glyphicon-hand-right text-bootstrap-primary"></i></button>
            <button type="button" title="Complete Evaluation" class="b-n b-n-r bg-transparent item-assess tooltips" onclick="assessForm($(this).closest('div').data('id'),$(this).closest('div').data('evaluationid'), event)"><i class="glyphicon glyphicon-play-circle text-bootstrap-primary"></i></button>
            @if(\Auth::user()->employee->id == $assessor->employee_id && $assessor->is_completed == '0')

            @endif
        </div>
    </div>
@endforeach






