@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Branch')

@section('modalTitle', 'Edit Recruitment Requests')
@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Submit">
    <a href="" class="btn btn-default pull-right" title="Show all Recruitment Request">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('postModalUrl', route('recruitment-requests.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('recruitment-requests.form', [
                'request' => $data,
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
    <form method="POST" action="{{ route('recruitment-requests.update', $data->id) }}" id="edit_recruitment_requests_form" name="edit_recruitment_requests_form" accept-charset="UTF-8" >
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