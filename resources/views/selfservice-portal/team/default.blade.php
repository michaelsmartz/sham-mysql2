@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Warning ! : No user associated')
@section('modalTitle', 'Warning ! : No user associated')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
@endsection

@section('postModalUrl', '#')

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            This employee can't be modified.
        </div>
    </div>
    @if(!Request::ajax())
        <div class="box-footer">
            @yield('modalFooter')
        </div>
    @endif
@endsection

@section('content')
    <form method="POST" action="#" id="edit_user_form" name="edit_user_form" accept-charset="UTF-8" >
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