@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Learning Material Type')
@section('modalTitle', 'Edit Learning Material Type')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('learning_material_types.index') }}" class="btn btn-default pull-right" title="Show all Learning Material Types">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('learning_material_types.store') }}" accept-charset="UTF-8" id="create_learning_material_type_form" name="create_learning_material_type_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('learning_material_types.form', [
                    'learningMaterialType' => null,
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