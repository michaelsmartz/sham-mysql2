@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'User profile "'.$profile->name.'" permission matrix')

@section('modalTitle', 'User profile "'.$profile->name.'" permission matrix')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('sham_user_profiles.matrix', $profile->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('sham_user_profiles.permissions_form', [
                'profile' => $profile,
                'permissions' => $permissions,
                'permissionMatrix' => $permissionMatrix,
            ])
        </div>
    </div>
    @if(!Request::ajax())
        <div class="box-footer">
            @yield('modalFooter')
        </div>
    @endif
@endsection

@section('content')
    <form method="POST" action="{{ route('sham_user_profiles.matrix', $profile->id) }}" id="sham_user_profile_matrix_form" name="sham_user_profile_matrix_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-body">
                @yield('modalContent')
            </div>
            <div class="box-footer">
                @yield('modalFooter')
            </div>
        </div>
    </form>
@endsection