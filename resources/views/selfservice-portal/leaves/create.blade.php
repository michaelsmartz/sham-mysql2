@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Leave Request : '.$leave_description)

@section('modalTitle', 'Leave Request : '.$leave_description)
@section('modalFooter')
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Apply</button>
@endsection

@section('postModalUrl', route('leaves.store'))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('selfservice-portal.leaves.form')
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