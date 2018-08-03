
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">Name</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', isset($assetSupplier->name) ? $assetSupplier->name : null) }}" minlength="1" maxlength="255" placeholder="Enter name here...">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address1') ? 'has-error' : '' }}">
    <label for="address1" class="col-md-2 control-label">Address1</label>
    <div class="col-md-10">
        <input class="form-control" name="address1" type="text" id="address1" value="{{ old('address1', isset($assetSupplier->address1) ? $assetSupplier->address1 : null) }}" minlength="1" placeholder="Enter address1 here...">
        {!! $errors->first('address1', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address2') ? 'has-error' : '' }}">
    <label for="address2" class="col-md-2 control-label">Address2</label>
    <div class="col-md-10">
        <input class="form-control" name="address2" type="text" id="address2" value="{{ old('address2', isset($assetSupplier->address2) ? $assetSupplier->address2 : null) }}" minlength="1" placeholder="Enter address2 here...">
        {!! $errors->first('address2', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address3') ? 'has-error' : '' }}">
    <label for="address3" class="col-md-2 control-label">Address3</label>
    <div class="col-md-10">
        <input class="form-control" name="address3" type="text" id="address3" value="{{ old('address3', isset($assetSupplier->address3) ? $assetSupplier->address3 : null) }}" minlength="1" placeholder="Enter address3 here...">
        {!! $errors->first('address3', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address4') ? 'has-error' : '' }}">
    <label for="address4" class="col-md-2 control-label">Address4</label>
    <div class="col-md-10">
        <input class="form-control" name="address4" type="text" id="address4" value="{{ old('address4', isset($assetSupplier->address4) ? $assetSupplier->address4 : null) }}" minlength="1" placeholder="Enter address4 here...">
        {!! $errors->first('address4', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('telephone') ? 'has-error' : '' }}">
    <label for="telephone" class="col-md-2 control-label">Telephone</label>
    <div class="col-md-10">
        <input class="form-control" name="telephone" type="text" id="telephone" value="{{ old('telephone', isset($assetSupplier->telephone) ? $assetSupplier->telephone : null) }}" minlength="1" placeholder="Enter telephone here...">
        {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email_address') ? 'has-error' : '' }}">
    <label for="email_address" class="col-md-2 control-label">Email Address</label>
    <div class="col-md-10">
        <input class="form-control" name="email_address" type="email" id="email_address" value="{{ old('email_address', isset($assetSupplier->email_address) ? $assetSupplier->email_address : null) }}" placeholder="Enter email address here...">
        {!! $errors->first('email_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('comments') ? 'has-error' : '' }}">
    <label for="comments" class="col-md-2 control-label">Comments</label>
    <div class="col-md-10">
        <input class="form-control" name="comments" type="text" id="comments" value="{{ old('comments', isset($assetSupplier->comments) ? $assetSupplier->comments : null) }}" minlength="1" placeholder="Enter comments here...">
        {!! $errors->first('comments', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">Is Active</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', isset($assetSupplier->is_active) ? $assetSupplier->is_active : null) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

