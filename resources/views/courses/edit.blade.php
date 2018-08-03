@extends('portal-index')
@section('title', 'Edit Course')
@section('content')
    <div class="box box-primary">
        <form method="POST" action="{{ route('courses.update', $data->id) }}" id="edit_course_form" name="edit_course_form" accept-charset="UTF-8" >
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">
            <div class="box-body">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="col-sm-12">
                            <div class="panel-body">
                                @include ('courses.form', [
                                            'course' => $data,
                                          ])

                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary pull-right" type="submit">Update</button>
                    <a href="{{route('courses.index')}}" class="btn pull-right">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection