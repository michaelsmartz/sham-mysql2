{!! Form::hidden('redirectsTo', URL::previous()) !!}
<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Name</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($assetSupplier)->name) }}" minlength="1" maxlength="100" required="true" placeholder="Enter name">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('address1') ? 'has-error' : '' }}">
    <label for="address1">Address1</label>
        <input class="form-control" name="address1" type="text" id="address1" value="{{ old('address1', optional($assetSupplier)->address1) }}" maxlength="100" required="true" placeholder="Enter address1">
        {!! $errors->first('address1', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('address2') ? 'has-error' : '' }}">
    <label for="address2">Address2</label>
        <input class="form-control" name="address2" type="text" id="address2" value="{{ old('address2', optional($assetSupplier)->address2) }}" maxlength="100" required="true" placeholder="Enter address2">
        {!! $errors->first('address2', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('address3') ? 'has-error' : '' }}">
    <label for="address3">Address3</label>
        <input class="form-control" name="address3" type="text" id="address3" value="{{ old('address3', optional($assetSupplier)->address3) }}" maxlength="100" placeholder="Enter address3">
        {!! $errors->first('address3', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('address4') ? 'has-error' : '' }}">
    <label for="address4">Address4</label>
        <input class="form-control" name="address4" type="text" id="address4" value="{{ old('address4', optional($assetSupplier)->address4) }}" maxlength="100" placeholder="Enter address4">
        {!! $errors->first('address4', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('telephone') ? 'has-error' : '' }}">
    <label for="telephone">Telephone</label>
        <input class="form-control" name="telephone" type="text" id="telephone" value="{{ old('telephone', optional($assetSupplier)->telephone) }}" maxlength="20" required="true" placeholder="Enter telephone">
        {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('email_address') ? 'has-error' : '' }}">
    <label for="email_address">Email Address</label>
        <input class="form-control" name="email_address" type="text" id="email_address" value="{{ old('email_address', optional($assetSupplier)->email_address) }}" maxlength="512" placeholder="Enter email address">
        {!! $errors->first('email_address', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('comments') ? 'has-error' : '' }}">
    <label for="comments">Comments</label>
        <input class="form-control" name="comments" type="text" id="comments" value="{{ old('comments', optional($assetSupplier)->comments) }}" maxlength="256" placeholder="Enter comments">
        {!! $errors->first('comments', '<p class="help-block">:message</p>') !!}
</div>

</div>