@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Country')
@section('modalTitle', 'Edit Country')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('countries.index') }}" class="btn btn-default pull-right" title="Show all Countries">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('countries.store') }}" accept-charset="UTF-8" id="create_country_form" name="create_country_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('countries.form', [
                    'country' => null,
                ])
            </div>
        </div>
        @if(!Request::ajax())
        <div class="box-footer">
            @yield('modalFooter') 
        </div>
        @endif
    </form>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
                @yield('modalContent') 
        </div>
    </div>
@endsection