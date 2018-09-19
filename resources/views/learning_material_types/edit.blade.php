@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Learning Material Type')

@section('modalTitle', 'Edit Learning Material Type')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('learning_material_types.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('learning_material_types.form', [
                'learningMaterialType' => $data,
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
    <form method="POST" action="{{ route('learning_material_types.update', $data->id) }}" id="edit_learning_material_type_form" name="edit_learning_material_type_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
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