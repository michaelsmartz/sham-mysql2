@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Sham User Profile')
@section('modalTitle', 'Edit Sham User Profile')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('sham_user_profiles.index') }}" class="btn btn-default pull-right" title="Show all Sham User Profiles">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('sham_user_profiles.store') }}" accept-charset="UTF-8" id="create_sham_user_profile_form" name="create_sham_user_profile_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('sham_user_profiles.form', [
                    'shamUserProfile' => null,
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