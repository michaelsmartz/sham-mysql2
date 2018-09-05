@extends('portal-index')
@section('content')
    <h4 class="modal-title">{{ $uModelName." Attachments" }}</h4>
    {!! Form::open(array('route' => array($routeName, $Id),'method'=>'POST', 'files'=>true)) !!}
        <div class="form-group">
            {!! Form::hidden('RemoveFileId') !!}
        </div>
        <table class="table table-striped tablesorter" id="new-table" data-toggle="table">
            <thead>
            <tr class="filters">
                <th>File name</th>
                <th style="text-align:right;">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($medias)&& count($medias)>0): ?>
            @foreach($medias as $media)
                <tr data-id='{{$media->id}}'>
                    <td>
                        {{ (isset($media))?$media->filename.'.'.$media->extension:"" }}
                    </td>
                    <td style="text-align:right;">
                        <button type="button" data-wenk="Download"
                                class="b-n b-n-r bg-transparent file-download">
                            <i class="glyphicon glyphicon-download text-primary"></i>
                        </button>
                        <a href="#!" class="b-n b-n-r bg-transparent file-remove" data-wenk="Remove">
                            <i class="glyphicon glyphicon-remove text-danger"></i>
                        </a>
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
        </div>
    {!! Form::close() !!}
@endsection
@section('post-body')
    <script>
        $(document).ready(
            function(){
                $('input:submit').attr('disabled',true);
                $('input:file').change(
                    function(){
                        if ($(this).val()){
                            $('input:submit').removeAttr('disabled');
                        }
                        else {
                            $('input:submit').attr('disabled',true);
                        }
                    });
            });
        $('.file-download').click(function () {
            let id = $(this).closest('tr').data("id");
            window.location = '{{url()->current()}}/' + id;
        });
        $('.file-remove').click(function () {
            let id = $(this).closest('tr').data("id");
            window.location = '{{url()->current()}}/' + id + '/detach';
        });
    </script>
@endsection