<div class="row">
    <div class="form-group col-xs-6 {{ $errors->has('username') ? 'has-error' : '' }}">
        <label for="username">Username</label>
            <input class="form-control" name="username" type="text" id="username" value="{{ old('username', optional($data)->username) }}" minlength="1" required="true" placeholder="Enter username" {!! ($mode =='edit')?'disabled':'' !!}>
            {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('password') ? 'has-error' : '' }}">
        <label for="password">Password <span class="text-info">(Leave blank for no change)</span></label>
            <input class="form-control" name="password" type="password" id="password" value="" placeholder="Enter password" autocomplete="new-password">
            {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email">Email</label>
            <input class="form-control" name="email" type="email" id="email" value="{{ old('email', optional($data)->email) }}" placeholder="Enter email" {!! ($mode =='edit')?'disabled':'' !!}>
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('cell_number') ? 'has-error' : '' }}">
        <label for="cell_number">Cell Number</label>
            <input class="form-control" name="cell_number" type="number" id="cell_number" value="{{ old('cell_number', optional($data)->cell_number) }}" placeholder="Enter cell number">
            {!! $errors->first('cell_number', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('sham_user_profile_id') ? 'has-error' : '' }}">
        <label for="sham_user_profile_id">User Profile</label>
        <select class="form-control" id="sham_user_profile_id" name="sham_user_profile_id" required="true">
            <option value="" style="display: none;" {{ old('sham_user_profile_id', optional($data)->sham_user_profile_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Sham User Profile</option>
            @foreach ($sham_user_profile_ids as $key => $sham_user_profile_id)
                <option value="{{ $key }}" {{ old('sham_user_profile_id', optional($data)->sham_user_profile_id) == $key ? 'selected' : '' }}>
                    {{ $sham_user_profile_id }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('sham_user_profile_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('employee_id') ? 'has-error' : '' }}">
        <label for="employee_id">Employee</label>
        <select class="form-control" id="employee_id" name="employee_id" required="true">
            <option value="" style="display: none;" {{ old('employee_id', optional($data)->employee_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Employee</option>
            @foreach ($employee_ids as $key => $employee_id)
                <option value="{{ $key }}" {{ old('employee_id', optional($data)->employee_id) == $key ? 'selected' : '' }}>
                    {{ $employee_id }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('silence_start') ? 'has-error' : '' }}">
        <label for="silence_start">Silence Start</label>
            <input class="form-control datepicker" name="silence_start" type="text" id="silence_start" value="{{ old('silence_start', optional($data)->silence_start) }}" minlength="1" placeholder="Enter silence start" data-date-format="H:i" data-enable-time="true" data-no-calendar="true">
            {!! $errors->first('silence_start', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('silence_end') ? 'has-error' : '' }}">
        <label for="silence_end">Silence End</label>
            <input class="form-control datepicker" name="silence_end" type="text" id="silence_end" value="{{ old('silence_end', optional($data)->silence_end) }}" minlength="1" placeholder="Enter silence end" data-date-format="H:i" data-enable-time="true" data-no-calendar="true">
            {!! $errors->first('silence_end', '<p class="help-block">:message</p>') !!}
    </div>

</div>