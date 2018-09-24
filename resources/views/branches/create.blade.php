@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Branch')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('branches.store') }}" accept-charset="UTF-8" id="create_branch_form" name="create_branch_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('branches.form', [
                            'branch' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('branches.index') }}" class="btn btn-default pull-right" title="Show all Branches">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection