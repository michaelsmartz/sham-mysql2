{!! Form::hidden('redirectsTo', URL::previous()) !!}
<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Name</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($asset)->name) }}" minlength="1" maxlength="100" required="true" placeholder="Enter name">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('asset_group_id') ? 'has-error' : '' }}">
    <label for="asset_group_id">Asset Group</label>
        <select class="form-control" id="asset_group_id" name="asset_group_id" required="true">
        	    <option value="" style="display: none;" {{ old('asset_group_id', optional($asset)->asset_group_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select asset group</option>
        	@foreach ($assetGroups as $key => $assetGroup)
			    <option value="{{ $key }}" {{ old('asset_group_id', optional($asset)->asset_group_id) == $key ? 'selected' : '' }}>
			    	{{ $assetGroup }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('asset_group_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('asset_supplier_id') ? 'has-error' : '' }}">
    <label for="asset_supplier_id">Asset Supplier</label>
        <select class="form-control" id="asset_supplier_id" name="asset_supplier_id" required="true">
        	    <option value="" style="display: none;" {{ old('asset_supplier_id', optional($asset)->asset_supplier_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select asset supplier</option>
        	@foreach ($assetSuppliers as $key => $assetSupplier)
			    <option value="{{ $key }}" {{ old('asset_supplier_id', optional($asset)->asset_supplier_id) == $key ? 'selected' : '' }}>
			    	{{ $assetSupplier }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('asset_supplier_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('tag') ? 'has-error' : '' }}">
    <label for="tag">Tag</label>
        <input class="form-control" name="tag" type="text" id="tag" value="{{ old('tag', optional($asset)->tag) }}" minlength="1" maxlength="50" required="true" placeholder="Enter tag">
        {!! $errors->first('tag', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('serial_no') ? 'has-error' : '' }}">
    <label for="serial_no">Serial No</label>
        <input class="form-control" name="serial_no" type="text" id="serial_no" value="{{ old('serial_no', optional($asset)->serial_no) }}" minlength="1" maxlength="20" required="true" placeholder="Enter serial no">
        {!! $errors->first('serial_no', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('purchase_price') ? 'has-error' : '' }}">
    <label for="purchase_price">Purchase Price</label>
        <input class="form-control" name="purchase_price" type="number" id="purchase_price" value="{{ old('purchase_price', optional($asset)->purchase_price) }}" min="-1000000000000000" max="1000000000000000" required="true" placeholder="Enter purchase price" step="any">
        {!! $errors->first('purchase_price', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('po_number') ? 'has-error' : '' }}">
    <label for="po_number">Po Number</label>
        <input class="form-control" name="po_number" type="text" id="po_number" value="{{ old('po_number', optional($asset)->po_number) }}" minlength="1" maxlength="20" required="true" placeholder="Enter po number">
        {!! $errors->first('po_number', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('warranty_expiry_date') ? 'has-error' : '' }}">
    <label for="warranty_expiry_date">Warranty Expiry Date</label>
        <input class="form-control" name="warranty_expiry_date" type="text" id="warranty_expiry_date" value="{{ old('warranty_expiry_date', optional($asset)->warranty_expiry_date) }}" required="true" placeholder="Enter warranty expiry date">
        {!! $errors->first('warranty_expiry_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('asset_condition_id') ? 'has-error' : '' }}">
    <label for="asset_condition_id">Asset Condition</label>
        <select class="form-control" id="asset_condition_id" name="asset_condition_id" required="true">
        	    <option value="" style="display: none;" {{ old('asset_condition_id', optional($asset)->asset_condition_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select asset condition</option>
        	@foreach ($assetConditions as $key => $assetCondition)
			    <option value="{{ $key }}" {{ old('asset_condition_id', optional($asset)->asset_condition_id) == $key ? 'selected' : '' }}>
			    	{{ $assetCondition }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('asset_condition_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('comments') ? 'has-error' : '' }}">
    <label for="comments">Comments</label>
        <textarea class="form-control" name="comments" cols="50" rows="5" id="comments" minlength="1" maxlength="256" required="true" placeholder="Enter comments">{{ old('comments', optional($asset)->comments) }}</textarea>
        {!! $errors->first('comments', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('is_available') ? 'has-error' : '' }}">
    <label for="is_available">Is Available</label>
        <input type="hidden" name="is_available" value="0">
        <div class="checkbox">
            <label for="is_available_1">
            	<input id="is_available_1" class="" name="is_available" type="checkbox" value="1" {{ old('is_available', optional($asset)->is_available) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_available', '<p class="help-block">:message</p>') !!}
</div>

</div>