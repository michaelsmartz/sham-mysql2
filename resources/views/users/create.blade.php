@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add User')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('users.store') }}" accept-charset="UTF-8" id="create_user_form" name="create_user_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('users.form', [
                            'data' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('users.index') }}" class="btn btn-default pull-right" title="Show all Users">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection