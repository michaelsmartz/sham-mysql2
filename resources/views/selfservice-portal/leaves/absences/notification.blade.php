<legend><i class="glyphicon glyphicon-exclamation-sign"></i>  Pending requests</legend>
@if(count($pending_request)>0)
<div>
    @foreach($pending_request as $request)
        <div class="card text-justify">
            <div class="container-fluid card-body bg-info pending-request">
                <div class="col-md-1">
                    <input type="checkbox" class="pending_box" name="pending_box[]" id="pending_box_{{$request->id}}" value={{$request->id}}>
                </div>
                <div class="col-md-9">
                    <p class="card-text"><b>{{$request->absence_description}}</b> request from <b>{{$request->employee}}</b></p>
                    <div class="small">From <b>{{\Carbon\Carbon::parse($request->starts_at)->format('Y-m-d H:i')}}</b> to <b>{{\Carbon\Carbon::parse($request->ends_at)->format('Y-m-d H:i')}}</b></div>
                </div>
                
                <div class="col-md-2">
                    <a href="#light-modal" data-wenk="Edit" style="top:5px;right:10px;" class="btn btn-primary" onclick="editForm('{{$request->id}}', event,'leaves')">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    <div class="form-group batch_status container-fluid">
        <div class="col-md-9">
            <label for="batch_operation"><input type="checkbox" id="bundle_check" value="0">  <span class="glyphicon glyphicon-check"></span> Batch operation</label>
            <select class="form-control" id="batch_operation" name="batch_operatione">
                <option value="0">Select batch operation</option>
                <option value="{{App\Enums\LeaveStatusType::status_approved}}">Approve selected</option>
                <option value="{{App\Enums\LeaveStatusType::status_denied}}">Deny selected</option>
            </select>
        </div>
        <div class="col-md-3">
           <button id="bundle_submit" type="button" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-save"></i> Save</button>
        </div>
       
    </div>
    <input name="leave_list" id="leave_list" value="" type="hidden">


</div>
@else
    <div class="container-fluid">There are no pending request.</div>
@endif