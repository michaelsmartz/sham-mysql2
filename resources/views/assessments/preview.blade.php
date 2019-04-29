@extends('portal-index')
@section('title', 'Preview Assessment')
@section('modalTitle', 'Preview Assessment')
@section('modalFooter')
    <a href="#!" class="btn close-modal" data-close="Close" data-dismiss="modal">Cancel</a>
@endsection

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('assessments.preview_form', [
                'assessment' => $assessment,
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
    <form id="preview_assessment_form" name="preview_assessment_form" accept-charset="UTF-8" >
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