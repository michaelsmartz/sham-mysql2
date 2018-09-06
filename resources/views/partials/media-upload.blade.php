<h4 class="modal-title">{{ $uModelName." Attachments" }}</h4>
{!! Form::open(array('route' => array($routeName, $Id),'method'=>'POST', 'files'=>true)) !!}
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
