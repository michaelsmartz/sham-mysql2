@extends('portal-index')
@section('title', 'Add Assessment')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('assessments.store') }}" accept-charset="UTF-8" id="create_assessment_form" name="create_assessment_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('assessments.form', [
                            'assessment' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('assessments.index') }}" class="btn btn-default pull-right" title="Show all Assessments">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('post-body')
    <script src="{{url('/')}}/plugins/multiselect/multiselect.min.js"></script>
    <script>
        $(function () {
            $('.multipleSelect').each(function(){
                $(this).multiselect({
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
        });
    </script>
@endsection