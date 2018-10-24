@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Review Assessment Response')

@section('modalTitle', 'Review Assessment Response')
@section('modalFooter')
    <a href="{{Session::get('redirectsTo') }}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('responses.update', ['module_assessment'=>$assessmentId, 'response' => $data->id]))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('module_assessment_responses.form', [
                'moduleAssessmentResponses' => $moduleAssessmentResponses,
                'moduleAssessment' => $moduleAssessment
            ])
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('responses.update', ['module_assessment'=>$assessmentId, 'response' => $data->id]) }}" id="edit_module_assessment_response_form" name="edit_module_assessment_response_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div class="box box-primary">
            <div class="box-body">
                    @yield('modalContent') 
            </div>
            <div class="box-footer text-right">
                @yield('modalFooter')
            </div>
        </div>
    </form>
@endsection

@section('post-body')
    <style>
        ul.questions {
            list-style-type: none;
            padding-left: 0px;
        }

        li.question-container {
            width: 100%;
            height: auto;
            border: 1px solid #222;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .disabled-score-box {
            width: 48px;
            text-align: left;
            display: inline-block;
            background: lightgrey;
            border: 1px inset rgb(227,227,227);
            padding: 2px;
            border-collapse: collapse;
        }

    </style>
@endsection