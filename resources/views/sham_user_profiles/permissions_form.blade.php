<button id="selectall" type="button" class="btn btn-primary" >Select All</button>
<button id="unselectall" type="button" class="btn btn-primary" >Unselect All</button>
<table class="table table-striped">
    <thead>
    <tr class="filters">
        <th></th>
        @foreach($permissions as $permissionKey=>$permissionValue)
            <th title="{{$permissionValue['description']}}">{{$permissionValue['alias']}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($permissionMatrix as  $permissionMatrixKey=>$permissionMatrixValue)
        @if (isset($submodules[$permissionMatrixKey]))
            <tr >
                <th>{!! $submodules[$permissionMatrixKey] !!}</th>
                @foreach($permissionMatrixValue as $key=>$value)
                    <td>
                        {!! Form::checkbox('Permission['.$permissionMatrixKey.']['.$key.']',$value,($value!=0),array('class'=>'permissionCheckBox'))!!}
                    </td>
                @endforeach
            </tr>
        @endif
    @endforeach
    </tbody>
</table>

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
        $(':checkbox').prop('checked','checked');
        $(':checkbox').val(1);
    });
    $("#unselectall").click(function(){  //"select all" click
        $(':checkbox').removeAttr('checked');
        $(':checkbox').val(0);
    });

    $(".permissionCheckBox").click(function(){
        if($(this).is(':checked')){
            this.setAttribute('checked','checked');
            $(this).val(1);
        }else{
            $(this).removeAttr('checked');
            $(this).val(0);
        }
    });
</script>

@if(!Request::ajax())
@endsection
@endif