@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Review Assessment Response')

@section('modalTitle', 'Review Assessment Response')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('module_assessment_responses.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('module_assessment_responses.form', [
                'moduleAssessmentResponse' => $data,
            ])
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('module_assessment_responses.update', $data->id) }}" id="edit_module_assessment_response_form" name="edit_module_assessment_response_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div class="box box-primary">
            <div class="box-body">
                    @yield('modalContent') 
            </div>
            <div class="box-footer">
                @yield('modalFooter')
            </div>
        </div>
    </form>
@endsection