@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Module Assessment')
@section('modalTitle', 'Edit Module Assessment')

@section('modalFooter')
    <a href="{{route('module_assessments.index')}}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait" id="btnSaveAssessment">Update</button>
@endsection

@section('postModalUrl', route('module_assessments.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('module_assessments.form', [
                'moduleAssessment' => $data,
                'fullPageEdit' => $fullPageEdit,
                '_mode' => 'edit'
            ])
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('module_assessments.update', $data->id) }}" id="assessmentForm" name="edit_module_assessment_form" accept-charset="UTF-8" >
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