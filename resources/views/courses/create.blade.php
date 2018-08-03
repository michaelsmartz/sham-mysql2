@extends('portal-index')
@section('title', 'Create New Course')
@section('content')
    <div class="box box-primary">
        <form method="POST" action="{{ route('courses.store') }}" accept-charset="UTF-8" id="[% form_id %]" name="[% form_name %]" class="form-horizontal"[% upload_files %]>
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="col-sm-12">
                            <div class="panel-body">
                            @include ('courses.form', [
                                                        'course' => null,
                                                    ])

                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('courses.index') }}" class="btn btn-default pull-right" data-wenk="Show all Courses">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection


