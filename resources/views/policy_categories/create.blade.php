@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Policy Category')
@section('modalTitle', 'Edit Policy Category')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('policy_categories.index') }}" class="btn btn-default pull-right" title="Show all Policy Categories">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('policy_categories.store') }}" accept-charset="UTF-8" id="create_policy_category_form" name="create_policy_category_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('policy_categories.form', [
                    'policyCategory' => null,
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