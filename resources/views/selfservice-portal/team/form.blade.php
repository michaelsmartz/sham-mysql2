<div class="row">
    <div class="form-group col-md-12">
        <legend><i class="glyphicon glyphicon-info-sign"></i> User info</legend>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-2">
        <label><i class="glyphicon glyphicon-user"></i>  Employee</label>
    </div>
    <div class="form-group col-md-4">
        {{$data->full_name}}
    </div>
    <div class="form-group col-md-2">
        <label><i class="glyphicon glyphicon-envelope"></i>  Email</label>
    </div>
    <div class="form-group col-md-4">
        {{$data->email}}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-2">
        <label><i class="glyphicon glyphicon-signal"></i>  User profil</label>
    </div>
    <div class="form-group col-md-4">
        {{$data->user_profil}}
    </div>
    <div class="form-group col-md-2">
        <label><i class="glyphicon glyphicon-qrcode"></i>  Cell number</label>
    </div>
    <div class="form-group col-md-4">
        {{$data->cell_number}}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12 {{ $errors->has('password') ? 'has-error' : '' }}">
        <legend><i class="glyphicon glyphicon-lock"></i> Password</legend>
        <label for="password"><i class="glyphicon glyphicon-eye-close"></i> New password <span class="text-info">(Leave blank for no change)</span></label>
        <input class="form-control" name="password" type="password" id="password" value="" placeholder="Enter password" autocomplete="new-password">
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>