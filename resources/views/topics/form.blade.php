<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('header') ? 'has-error' : '' }}">
    <label for="header">Topic Heading</label>
        <input class="form-control" name="header" type="text" id="header" value="{{ old('header', optional($topic)->header) }}" minlength="1" maxlength="299" required="true" placeholder="Enter header">
        {!! $errors->first('header', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('data') ? 'has-error' : '' }}">
    <label for="data">Content</label>
        <input class="form-control" name="data" type="text" id="data" value="{{ old('data', optional($topic)->data) }}" minlength="1" placeholder="Enter data">
        {!! $errors->first('data', '<p class="help-block">:message</p>') !!}
</div>

</div>