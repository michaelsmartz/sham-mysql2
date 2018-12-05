@extends('portal-index')
@section('title', 'Edit Assessment')
@section('modalTitle', 'Edit Assessment')

@section('modalFooter')
    @if((isset($data))&& !$data->isAssessmentInUse())
        <button class="btn btn-primary pull-right" type="submit">Update</button>
    @endif
    <a href="{{route('assessments.index')}}" class="btn pull-right" data-close="Close" data-dismiss="modal">Cancel</a>
@endsection

@section('postModalUrl', route('assessments.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('assessments.form', [
                'assessment' => $data,
            ])
        </div>
    </div>

@endsection

@section('content')
    <form method="POST" action="{{ route('assessments.update', $data->id) }}" id="edit_assessment_form" name="edit_assessment_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        @yield('modalContent')
        <p>
        <div class="row">
            <div class="col-sm-12 text-right">
                @yield('modalFooter')
            </div>
        </div>
        </p>

    </form>
@endsection

@section('post-body')
    <script src="{{url('/')}}/plugins/multiselect/multiselect.min.js"></script>
    <script>
        $(function () {
            $('#multiselect').multiselect({
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
    </script>
@endsection