@extends('portal-index')
@section('title', 'Edit Topic')
@section('content')
    <div class="box box-primary">
        <form method="POST" action="{{ route('topics.update', $data->id) }}" id="edit_topic_form" name="edit_topic_form" accept-charset="UTF-8" >
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">
            <div class="box-body">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="col-sm-12">
                            <div class="panel-body">
                                @include ('topics.form', [
                                            'topic' => $data,
                                          ])

                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary pull-right" type="submit">Update</button>
                    <a href="{{route('topics.index')}}" class="btn pull-right">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection