<div class="row">
    <div class="form-group col-md-12 {{ $errors->has('password') ? 'has-error' : '' }}">
        <label for="password">Password <span class="text-info">(Leave blank for no change)</span></label>
        <input class="form-control" name="password" type="password" id="password" value="" placeholder="Enter password" autocomplete="new-password">
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>