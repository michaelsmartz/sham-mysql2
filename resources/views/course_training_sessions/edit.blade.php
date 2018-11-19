@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Training Session')
@section('modalTitle', 'Edit Training Session')

@if( optional($data)->is_final == 1)
    @section('modalFooter')
        <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    @endsection
@else
    @section('modalFooter')
        <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
    @endsection
@endif

@section('postModalUrl') 
    {{ optional($data)->is_final == 1 ? '' : route('course_training_sessions.update', $data->id) }}
@endsection

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('course_training_sessions.form', [
                'courseTrainingSession' => $data,
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
    <form method="POST" action="{{route('course_training_sessions.update', $data->id)}}" id="edit_course_training_session_form" name="edit_course_training_session_form" accept-charset="UTF-8" >
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