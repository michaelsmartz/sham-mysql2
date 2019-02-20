<div class="row">

    <div class="form-group col-xs-12 {{ $errors->has('violation_id') ? 'has-error' : '' }}">
        <label for="violation_id">Violation</label>
            <select class="form-control" id="violation_id" name="violation_id" required="true">
                    <option value="" style="display: none;" {{ old('violation_id', optional($disciplinaryAction)->violation_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select violation</option>
                @foreach ($violations as $key => $violation)
                    <option value="{{ $key }}" {{ old('violation_id', optional($disciplinaryAction)->violation_id) == $key ? 'selected' : '' }}>
                        {{ $violation }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('violation_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('employee_statement') ? 'has-error' : '' }}">
        <label for="employee_statement">Employee Statement</label>
        <textarea class="form-control" name="employee_statement" cols="50" rows="5" id="employee_statement" minlength="1" maxlength="4294967295" required="true" placeholder="Enter employee statement">{{ old('employee_statement', optional($disciplinaryAction)->employee_statement) }}</textarea>
        {!! $errors->first('employee_statement', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('employer_statement') ? 'has-error' : '' }}">
        <label for="employer_statement">Employer Statement</label>
        <textarea class="form-control" name="employer_statement" cols="50" rows="5" id="employer_statement" minlength="1" maxlength="4294967295" required="true" placeholder="Enter employee statement">{{ old('employer_statement', optional($disciplinaryAction)->employer_statement) }}</textarea>
        {!! $errors->first('employer_statement', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-4 {{ $errors->has('violation_date') ? 'has-error' : '' }}">
        <label for="violation_date">Violation Date</label>
        <input class="form-control datepicker" name="violation_date" type="text" id="violation_date" value="{{ old('violation_date', optional($disciplinaryAction)->violation_date) }}" placeholder="Enter violation date">
        {!! $errors->first('violation_date', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-4 {{ $errors->has('date_issued') ? 'has-error' : '' }}">
        <label for="date_issued">Date Issued</label>
        <input class="form-control datepicker" name="date_issued" type="text" id="date_issued" value="{{ old('date_issued', optional($disciplinaryAction)->date_issued) }}" placeholder="Enter date issued">
        {!! $errors->first('date_issued', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-4 {{ $errors->has('date_expires') ? 'has-error' : '' }}">
        <label for="date_expires">Date Expires</label>
        <input class="form-control datepicker" name="date_expires" type="text" id="date_expires" value="{{ old('date_expires', optional($disciplinaryAction)->date_expires) }}" placeholder="Enter date expires">
        {!! $errors->first('date_expires', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('decision') ? 'has-error' : '' }}">
        <label for="decision">Decision</label>
        <textarea class="form-control" name="decision" cols="50" rows="5" id="decision" minlength="1" maxlength="4294967295" required="true" placeholder="Enter decision">{{ old('decision', optional($disciplinaryAction)->decision) }}</textarea>
        {!! $errors->first('decision', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('disciplinary_decision_id') ? 'has-error' : '' }}">
        <label for="disciplinary_decision_id">Disciplinary Decision</label>
        <select class="form-control" id="disciplinary_decision_id" name="disciplinary_decision_id">
                <option value="" style="display: none;" {{ old('disciplinary_decision_id', optional($disciplinaryAction)->disciplinary_decision_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select disciplinary decision</option>
            @foreach ($disciplinaryDecisions as $key => $disciplinaryDecision)
                <option value="{{ $key }}" {{ old('disciplinary_decision_id', optional($disciplinaryAction)->disciplinary_decision_id) == $key ? 'selected' : '' }}>
                    {{ $disciplinaryDecision }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('disciplinary_decision_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div id="date-picker"> </div>

    <input type="hidden" id="employee_id" name="employee_id" value="{{ old('employee_id', isset($id)? $id:optional($disciplinaryAction)->employee_id) }}">
    <input type="hidden" id="updated_by" name="updated_by" value="{{ old('updated_by', isset($updated_by)? $updated_by:null) }}">

</div>