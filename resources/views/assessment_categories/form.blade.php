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

<div class="form-group col-xs-12" style="padding-top: 20px;">
    <div class="flex-wrapper">
        <div class="col-xs-5" style="padding-left: 0px;">
            {!! Form::select('from[]', $categoryquestions, null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control multipleSelect', 'id'=>'multiselect')) !!}
        </div>
        <div class="col-xs-2">
            <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
            <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
            <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
            <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
        </div>
        <div class="col-xs-5" style="padding-right: 0px;">
            {!! Form::select('accq[]', isset($accq)?$accq:[],null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control', 'id'=>'multiselect_to')) !!}
        </div>
        {!! $errors->first('accq[]', '<p class="help-block">:message</p>') !!}
    </div>
</div>

</div>