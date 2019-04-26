@extends('portal-index')
@section('title', 'Clone Assessment')
@section('modalTitle', 'Clone Assessment')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Clone</button>
@endsection

@section('postModalUrl', route('assessment.clone', $assessment->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('assessments.clone_form', [
                'assessment' => $assessment,
                'assessmentCategories' => $assessmentCategories,
            ])
        </div>
    </div>
    @if(!Request::ajax())
    <div class="box-footer">
        @yield('modalFooter')
    </div>
    @endif
@endsection

@section('content')
    <form method="POST" action="{{ route('assessment.clone', $assessment->id) }}" id="clone_assessment_form" name="clone_assessment_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
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