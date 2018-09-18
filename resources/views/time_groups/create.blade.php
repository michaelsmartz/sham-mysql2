@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Time Group')
@section('modalTitle', 'Edit Time Group')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('time_groups.index') }}" class="btn btn-default pull-right" title="Show all Time Groups">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('time_groups.store') }}" accept-charset="UTF-8" id="create_time_group_form" name="create_time_group_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('time_groups.form', [
                    'timeGroup' => null,
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