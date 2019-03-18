<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($offer)->description) }}" minlength="1" maxlength="100" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('content') ? 'has-error' : '' }}">
    <label for="content">Content</label>
        <textarea class="form-control" name="content" cols="50" rows="5" id="tiny" required="true" placeholder="Enter content">{{ old('content', optional($offer)->content) }}</textarea>
        {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>

</div>

@section('post-body')
    <script src="{{URL::to('/')}}/js/tinymce.min.js"></script>
@endsection