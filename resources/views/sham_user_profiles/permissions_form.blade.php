<div class="row">
    <button id="selectall" type="button" class="btn btn-default bg-grey b-r4" >Select All</button>
    <button id="unselectall" type="button" class="btn btn-default bg-grey b-r4" >Unselect All</button>
    <table class="table table-striped">
        <thead>
        <tr class="filters">
            <th></th>
            @foreach($permissions as $permissionKey=>$permissionValue)
                <th title="{{$permissionValue['Description']}}">{{$permissionValue['Name']}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($permissionMatrix as  $permissionMatrixKey=>$permissionMatrixValue)
            @if (isset($submodules[$permissionMatrixKey]))
                <tr >
                    <th>{!! $submodules[$permissionMatrixKey] !!}</th>
                    @foreach($permissionMatrixValue as $key=>$value)
                        <td> {!! Form::checkbox('Permission['.$permissionMatrixKey.']['.$key.']',$value,($value!=0))!!}</td>
                    @endforeach
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

@if(!Request::ajax())
@section('post-body')
@endif
<style>
    .light-modal-content.large-content {
        width: 65vw;!important;
    }
</style>

<script>
    //select all checkboxes
    $("#selectall").click(function(){  //"select all" click
        $(':checkbox').prop('checked',true);
    });
    $("#unselectall").click(function(){  //"select all" click
        $(':checkbox').prop('checked',false);
    });
</script>

@if(!Request::ajax())
@endsection
@endif