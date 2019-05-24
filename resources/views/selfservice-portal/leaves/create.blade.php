@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Leave Request : '.$leave_description)

@section('modalTitle', 'Leave Request : '.$leave_description)
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Apply</button>
@endsection

@section('postModalUrl', route('leaves.store'))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('selfservice-portal.leaves.form')
            <input type='hidden' id='monday' value="9:00-17:00">
            <input type='hidden' id='tuesday' value="9:00-17:00">
            <input type='hidden' id='thursday' value="8:30-16:30">
            <input type='hidden' id='friday' value="8:00-16:00">
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('leaves.store') }}" id="leave_form" name="leave_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
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