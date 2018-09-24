@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Ethnic Group')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('ethnic_groups.store') }}" accept-charset="UTF-8" id="create_ethnic_group_form" name="create_ethnic_group_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('ethnic_groups.form', [
                            'ethnicGroup' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('ethnic_groups.index') }}" class="btn btn-default pull-right" title="Show all Ethnic Groups">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection