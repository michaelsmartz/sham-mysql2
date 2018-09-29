@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'View Asset Employee')

@section('modalTitle', 'View Asset Employee')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
@endsection

@section('postModalUrl', '')
@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            <dl class="dl-horizontal">
                <dt>Asset</dt>
                <dd>{{ optional($data->asset)->name }}</dd>
                <dt>Employee</dt>
                <dd>{{ optional($data->employee)->full_name }}</dd>
                <dt>Date Out</dt>
                <dd>{{ $data->date_out }}</dd>
                <dt>Date In</dt>
                <dd>{{ $data->date_in }}</dd>
                <dt>Comment</dt>
                <dd>{{ $data->comment }}</dd>
            </dl>
        </div>
    </div>
    @if(!Request::ajax())
    <div class="box-footer">
        @yield('modalFooter') 
    </div>
    @endif
@endsection