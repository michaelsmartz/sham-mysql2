@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Assessment Category')

@section('modalTitle', 'Edit Assessment Category')
@section('modalFooter')
    @if((isset($data))&& !$data->isAssessmentCategoryInUse())
        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
    @endif
    <a href="{{route('assessment_categories.index')}}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>

@endsection

@section('postModalUrl', route('assessment_categories.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('assessment_categories.form', [
                'assessmentCategory' => $data,
            ])
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('assessment_categories.update', $data->id) }}" id="edit_assessment_category_form" name="edit_assessment_category_form" accept-charset="UTF-8" >
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