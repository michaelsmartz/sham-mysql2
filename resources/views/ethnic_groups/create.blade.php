@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Ethnic Group')
@section('modalTitle', 'Edit Ethnic Group')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('ethnic_groups.index') }}" class="btn btn-default pull-right" title="Show all Ethnic Groups">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('ethnic_groups.store') }}" accept-charset="UTF-8" id="create_ethnic_group_form" name="create_ethnic_group_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('ethnic_groups.form', [
                    'ethnicGroup' => null,
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