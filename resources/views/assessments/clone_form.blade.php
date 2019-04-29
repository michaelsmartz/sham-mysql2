<div class="row">
    <div class="form-group col-xs-6 {{ $errors->has('name') ? 'has-error' : '' }}">
        <label for="name">Assessment Name</label>
            <input class="form-control" type="text" value="{{ old('name', isset($assessment->name) ? $assessment->name : null) }}" readonly="readonly" disabled="disabled">
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('name') ? 'has-error' : '' }} pull-right">
        <label for="name">New Assessment Name</label>
        <input class="form-control" name="assessment" type="text" id="assessment"  minlength="1" maxlength="1024" required="true" placeholder="Enter new assessment name">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    @foreach($assessmentCategories as $key=>$assessmentCategory)
        <div class="form-group col-xs-6 {{ $errors->has('assessmentCategory_'.$assessmentCategory->id) ? 'has-error' : '' }}">
            <label for="name">Assessment Category Name</label>
            <input class="form-control" type="text" value="{{ old('name', isset($assessmentCategory->name) ? $assessmentCategory->name : null) }}" readonly="readonly" disabled="disabled">
            {!! $errors->first('assessmentCategory[]', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group col-xs-6 {{ $errors->has('assessmentCategory_'.$assessmentCategory->id) ? 'has-error' : '' }}">
            <label for="name">New Assessment Category Name</label>
            <input class="form-control" name="assessmentCategory[]" type="text" id="assessmentCategory[]"  minlength="1" maxlength="1024" required="true" placeholder="Enter new assessment category name">
            {!! $errors->first('assessmentCategory[]', '<p class="help-block">:message</p>') !!}
        </div>
    @endforeach
</div>