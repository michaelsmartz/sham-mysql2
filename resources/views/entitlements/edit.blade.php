@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Entitlement')

@section('modalTitle', 'Edit Entitlement')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    @if(!is_null($employee_id) && $employee_id != optional($data)->employee_id)
        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
    @endif
@endsection

@section('postModalUrl', route('entitlements.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('entitlements.form', [
                'mode' => 'edit',
                'entitlement' => $data,
                'employee_id' => $employee_id,
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
    <form method="POST" action="{{ route('entitlements.update', $data->id) }}" id="edit_entitlement_form" name="edit_entitlement_form" accept-charset="UTF-8" >
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