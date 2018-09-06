<?php if (isset($medias)&& count($medias)>0){ ?>
<table class="table table-striped tablesorter" id="new-table" data-toggle="table">
    <thead>
    <tr class="filters">
        <th>File name</th>
        <th style="text-align:right;">Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($medias as $media)
        <tr data-id='{{$media->id}}'>
            <td>
                {{ (isset($media))?$media->filename.'.'.$media->extension:"" }}
            </td>
            <td style="text-align:right;">
                <a href="{{url()->current()}}/{{$media->id}}" class="b-n b-n-r bg-transparent file-download" data-wenk="Download">
                    <i class="glyphicon glyphicon-download text-primary"></i>
                </a>
                <a href="{{url()->current()}}/{{$media->id}}/detach" class="b-n b-n-r bg-transparent file-remove" data-wenk="Remove">
                    <i class="glyphicon glyphicon-remove text-danger"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<?php
}else{
?>
    <p>Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new attachments<p>
<?php
}
?>