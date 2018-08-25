@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Law')

@section('modalTitle', 'Edit Law')
@section('modalFooter')
    <button class="btn btn-primary pull-right" type="submit">Update</button>
    <a href="{{route('laws.index')}}" class="btn pull-right">Cancel</a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('laws.update', $data->id) }}" id="edit_law_form" name="edit_law_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-sm-12">
                @include ('laws.form', [
                            'law' => $data,
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