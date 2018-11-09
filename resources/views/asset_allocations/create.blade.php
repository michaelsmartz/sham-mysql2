@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Asset Allocation')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('asset_allocations.store') }}" accept-charset="UTF-8" id="create_asset_employee_form" name="create_asset_employee_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('asset_allocations.form', [
                            'assetEmployee' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('asset_allocations.index') }}" class="btn btn-default pull-right" title="Show all Asset Allocations">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection