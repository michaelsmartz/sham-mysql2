@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Assessment')
@section('modalTitle', 'Edit Assessment')

@section('modalFooter')
    <button class="btn btn-primary pull-right" type="submit">Update</button>
    <a href="{{route('assessments.index')}}" class="btn pull-right" data-close="Close" data-dismiss="modal">Cancel</a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('assessments.update', $data->id) }}" id="edit_assessment_form" name="edit_assessment_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-sm-12">
                @include ('assessments.form', [
                    'assessment' => $data,
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