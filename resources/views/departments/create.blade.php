@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Department')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('departments.store') }}" accept-charset="UTF-8" id="create_department_form" name="create_department_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('departments.form', [
                            'department' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('departments.index') }}" class="btn btn-default pull-right" title="Show all Departments">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection