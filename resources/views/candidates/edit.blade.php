@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Candidate')

@section('modalTitle', 'Edit Candidate')
@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Submit">
    <a href="{{ route('candidates.index') }}" class="btn btn-default pull-right" title="Show all recruitment requests">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
    @component('partials.index', [])
    @endcomponent
@endsection

@section('postModalUrl', route('candidates.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="col-sm-12">
                <div class="panel-body">
                    @include ('candidates.form', [
                        'candidate' => $data,
                         'uploader' => $uploader
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" id="candidates" action="{{ route('candidates.update', $data->id) }}" name="edit_candidates_form" accept-charset="UTF-8" data-parsley-validate="" enctype="multipart/form-data">
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