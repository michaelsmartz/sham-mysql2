<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title">Title</label>
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($survey)->title) }}" minlength="1" maxlength="100" required="true" placeholder="Enter title">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('date_start') ? 'has-error' : '' }}">
    <label for="date_start">Start Date</label>
        <input class="form-control" name="date_start" type="text" id="date_start" value="{{ old('date_start', optional($survey)->date_start) }}" minlength="1" required="true" placeholder="Enter start date">
        {!! $errors->first('date_start', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('EndDate') ? 'has-error' : '' }}">
    <label for="EndDate">End Date</label>
        <input class="form-control" name="EndDate" type="text" id="EndDate" value="{{ old('EndDate', optional($survey)->EndDate) }}" minlength="1" required="true" placeholder="Enter end date">
        {!! $errors->first('EndDate', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('final') ? 'has-error' : '' }}">
    <label for="final">Final</label>
        <input class="form-control" name="final" type="text" id="final" value="{{ old('final', optional($survey)->final) }}" minlength="1" required="true" placeholder="Enter final">
        {!! $errors->first('final', '<p class="help-block">:message</p>') !!}
</div>

</div>