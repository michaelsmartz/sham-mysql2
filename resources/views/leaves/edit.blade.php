@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Leave request : ')
@section('modalTitle', 'Leave request : ')


@section('modalFooter')
    <a href="#!" class="btn btn-danger" data-close="Close" data-dismiss="modal">Deny</a>
    <button class="btn btn-success" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Approve</button>
@endsection

@section('postModalUrl', route('leaves.update',$id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('leaves.form')
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{route('leaves.update',$id)}}" id="leave_request_form" name="leave_request_form" accept-charset="UTF-8" class="form-horizontal">
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
