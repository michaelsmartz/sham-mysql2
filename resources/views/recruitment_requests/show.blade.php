@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'View Recruitment Request')

@section('modalTitle', 'View Recruitment Requests')
@section('modalFooter')
    @if($processed)
        <a href="{{ route('recruitment_requests.index') }}" class="btn btn-primary pull-right" title="Show all Recruitment Request">
            Close
        </a>
    @else
        <input class="btn btn-primary pull-right" type="submit" value="Submit">
        <a href="{{ route('recruitment_requests.index') }}" class="btn btn-default pull-right" title="Show all Recruitment Request">
            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
        </a>
    @endif
@endsection

@section('postModalUrl', route('recruitment_requests.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="col-sm-12">
                <div class="panel-body">
                    @include ('recruitment_requests.form', [
                        'request' => $data,
                        'processed' => $processed,
                        '_mode'=>'show'
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" id="recruitment-requests" action="{{ route('recruitment_requests.update', $data->id) }}" name="edit_recruitment_requests_form" data-parsley-validate="" accept-charset="UTF-8" >
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