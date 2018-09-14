@extends('portal-index')
@section('title', 'Edit Course')
@section('modalTitle', 'Edit Course')

@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('courses.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('courses.form', [
                        'course' => $data,
                        ])
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('courses.update', $data->id) }}" id="edit_course_form" name="edit_course_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        @yield('modalContent')
        <p>
            <div class="row">
                <div class="col-sm-12 text-right"> 
                @yield('modalFooter')
                </div>
            </div>
        </p>
    </form>
@endsection

@section('post-body')
    <script src="{{url('/')}}/plugins/multiple-select/multiple-select.min.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/plugins/multiple-select/multiple-select.min.css">
    <script>
    $(function () {
        $('select').multipleSelect({
            filter: true
        });
    });
    </script>
@endsection