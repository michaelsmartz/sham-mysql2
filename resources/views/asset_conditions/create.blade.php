@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Asset Condition')
@section('modalTitle', 'Edit Asset Condition')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('asset_conditions.index') }}" class="btn btn-default pull-right" title="Show all Asset Conditions">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('asset_conditions.store') }}" accept-charset="UTF-8" id="create_asset_condition_form" name="create_asset_condition_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('asset_conditions.form', [
                    'assetCondition' => null,
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