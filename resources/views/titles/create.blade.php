@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Title')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('titles.store') }}" accept-charset="UTF-8" id="create_title_form" name="create_title_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('titles.form', [
                            'title' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('titles.index') }}" class="btn btn-default pull-right" title="Show all Titles">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection