@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Leave Request : '.$leave_description)

@section('modalTitle', 'Leave Request : '.$leave_description)
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button id="btn-leave-apply" class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Apply</button>
@endsection

@section('postModalUrl', route('my-leaves.store'))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('selfservice-portal.leaves.form')
            @foreach ($time_period as $key => $period)
                <input type='hidden' id="{{$key}}" value="{{$period['start_time']}}-{{$period['end_time']}}">
            @endforeach
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('my-leaves.store') }}" id="leave_form" name="leave_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        {!! method_field('post') !!}
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