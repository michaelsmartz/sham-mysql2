<h4 class="modal-title">{{ $uModelName." Attachments" }}</h4>
{!! Form::open(array('route' => array($routeName, $Id),'method'=>'POST', 'files'=>true)) !!}
@if($uModelName == "Employee")
    <div class="form-group">
        <div class="row">
            <div class="col-xs-6">
                {!! Form::label('comment', 'Comment', ['class' => 'comment']); !!}
                {!! Form::text('comment') !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xs-6">
                {!! Form::label('extrable_type', 'extrable_type', ['class' => 'extrable_type']); !!}
                {!! Form::text('Extrable Type') !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xs-6">
                {!! Form::label('extrable_id', 'extrable_id', ['class' => 'extrable_id']); !!}
                {!! Form::text('Extrable Id') !!}
            </div>
        </div>
    </div>
@endif
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
