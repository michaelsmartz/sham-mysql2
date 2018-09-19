@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Team')
@section('modalTitle', 'Edit Team')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('teams.index') }}" class="btn btn-default pull-right" title="Show all Teams">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('teams.store') }}" accept-charset="UTF-8" id="create_team_form" name="create_team_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('teams.form', [
                    'team' => null,
                ])
            </div>
        </div>
        @if(!Request::ajax())
        <div class="box-footer">
            @yield('modalFooter') 
        </div>
        @endif
    </form>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
                @yield('modalContent') 
        </div>
    </div>
@endsection

@section('post-body')
    <script src="{{url('/')}}/plugins/multiple-select/multiple-select.min.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/plugins/multiple-select/multiple-select.min.css">
    <script>
        $(function () {
            $('.products').multipleSelect({
                filter: true
            });
        });
    </script>
@endsection