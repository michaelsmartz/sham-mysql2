@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Sham User')
@section('modalTitle', 'Edit Sham User')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('sham_users.index') }}" class="btn btn-default pull-right" title="Show all Sham Users">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('sham_users.store') }}" accept-charset="UTF-8" id="create_sham_user_form" name="create_sham_user_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('sham_users.form', [
                    'shamUser' => null,
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