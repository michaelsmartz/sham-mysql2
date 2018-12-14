@if((isset($assessmentCategory))&& $assessmentCategory->isAssessmentCategoryInUse())
    <div class="alert alert-danger" style="margin-bottom: 0px;">
        <p>This Assessment Category is already in use and cannot be edited.</p>
    </div>
    <br>
@endif
<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Name</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($assessmentCategory)->name) }}" minlength="1" maxlength="1024" required="true" placeholder="Enter name">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($assessmentCategory)->description) }}" minlength="1" maxlength="1024" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('passmark_percentage') ? 'has-error' : '' }}">
    <label for="passmark_percentage">Passmark Percentage</label>
        <input class="form-control" name="passmark_percentage" type="number" id="passmark_percentage" value="{{ old('passmark_percentage', optional($assessmentCategory)->passmark_percentage) }}" min="-9" max="9" placeholder="Enter passmark percentage">
        {!! $errors->first('passmark_percentage', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('modules[]') ? 'has-error' : '' }}">
    <label for="from[]">Category questions <i class="fa fa-question-circle" data-wenk="Link existing category questions" data-wenk-pos="right"></i></label>
</div>

<div class="col-xs-12">
    <div class="flex-wrapper">
        <div class="col-xs-12" style="padding-left: 0px;">
            {!! Form::select('from[]', $categoryquestions, null, array('multiple' => 'multiple', 'size' => '10', 'class'=> 'form-control multipleSelect', 'id'=>'multiselect')) !!}
        </div>
    </div>
    <br>
</div>
<div class="col-xs-6 col-xs-offset-3">
    <div class="col-xs-6">
        <button type="button" id="multiselect_rightAll" class="btn btn-block" data-wenk="Select All"><i class="fa fa-angle-double-down" style="font-weight:900"></i></button>
        <button type="button" id="multiselect_rightSelected" class="btn btn-block" data-wenk="Add Selected"><i class="fa fa-angle-down" style="font-weight:900"></i></button>
    </div>
    <div class="col-xs-6">
        <button type="button" id="multiselect_leftSelected" class="btn btn-block" data-wenk="Remove Selected"><i class="fa fa-angle-up" style="font-weight:900"></i></button>
        <button type="button" id="multiselect_leftAll" class="btn btn-block" data-wenk="Unselect All"><i class="fa fa-angle-double-up" style="font-weight:900"></i></button>
    </div>
</div>
<div class="col-xs-12">
    <br>
    <div class="flex-wrapper">
        <div class="col-xs-12">
            {!! Form::select('accq[]', isset($accq)?$accq:[],null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control', 'id'=>'multiselect_to')) !!}
        </div>
        {!! $errors->first('accq[]', '<p class="help-block">:message</p>') !!}
    </div>
</div>

</div>