@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Sham User Profile')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('sham_user_profiles.store') }}" accept-charset="UTF-8" id="create_sham_user_profile_form" name="create_sham_user_profile_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('sham_user_profiles.form', [
                            'shamUserProfile' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('sham_user_profiles.index') }}" class="btn btn-default pull-right" title="Show all Sham User Profiles">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection