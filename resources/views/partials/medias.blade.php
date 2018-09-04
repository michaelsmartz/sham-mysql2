@extends('portal-index')
@section('content')
    <h4 class="modal-title">{{ $directory }}</h4>
    {!! Form::open(array('route' => array($routeName, $Id),'method'=>'POST', 'files'=>true)) !!}
        <div class="form-group">
            {!! Form::hidden('RemoveFileId') !!}
        </div>
        <table class="table table-striped tablesorter">
            <thead>
            <tr class="filters">
                <th>File name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($medias)&& count($medias)>0): ?>
            @foreach($medias as $media)
                <tr data-id='{{$media->id}}'>
                    <td>
                        {{ (isset($media))?$media->filename.'.'.$media->extension:"" }}
                    </td>
                    <td>
                        <button type="button" title="Download" class="btn btn-default btn-xs file-download"><i class="glyphicon glyphicon-download"></i></button>
                        <button type="button" title="Remove"
                                class="btn btn-default btn-xs file-remove"><i class="glyphicon glyphicon-remove"></i></button>
                    </td>
                </tr>
            @endforeach
            <?php endif; ?>
            </tbody>
        </table>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-6">
                    {!! Form::file('Attachment',['class'=>'btn bg-bootstrap-primary b-r4 text-white']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::submit('Upload',['class'=>'btn bg-gold b-r4 text-white has-spinner']) !!}
            <button type="button" class="btn btn-default bg-grey b-r4" data-dismiss="modal">Cancel</button>
        </div>
    {!! Form::close() !!}
@stop
@section('post-body')
    <script>
        $('.file-download').click(function () {
            let id = $(this).closest('tr').data("id");
            window.location = '{{url()->current()}}/' + id;
        });
        $('.file-remove').click(function () {
            var id = $(this).closest('tr').data("id");
            $('#md-content').load('{{url()->current()}}/' + id, {'_token': '{!! csrf_token() !!}'});
        });
    </script>
@stop
@component('partials.index', ['routeName'=> 'laws.destroy'])
@endcomponent