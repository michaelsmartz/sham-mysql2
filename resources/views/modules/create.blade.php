@extends('portal-index')
@section('title', 'Create New Module')
@section('content')
    <div class="box box-primary">
        <form method="POST" action="{{ route('modules.store') }}" accept-charset="UTF-8" id="create_module_form" name="create_module_form" class="form-horizontal">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="col-sm-12">
                            <div class="panel-body">
                                @include('modules.form', [
                                    'module' => null,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('modules.index') }}" class="btn btn-default pull-right" title="Show All Module">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </form>
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
