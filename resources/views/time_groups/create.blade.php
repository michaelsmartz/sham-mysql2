@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Time Group')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('time_groups.store') }}" accept-charset="UTF-8" id="create_time_group_form" name="create_time_group_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('time_groups.form', [
                            'timeGroup' => null,
                            '_mode'=>'create'
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('time_groups.index') }}" class="btn btn-default pull-right" title="Show all Time Groups">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection