@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Employee Status')

@section('modalTitle', 'Edit Employee Status')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('employee_statuses.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('employee_statuses.form', [
                'employeeStatus' => $data,
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
    <form method="POST" action="{{ route('employee_statuses.update', $data->id) }}" id="edit_employee_status_form" name="edit_employee_status_form" accept-charset="UTF-8" >
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