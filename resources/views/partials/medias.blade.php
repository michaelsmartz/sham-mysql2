<?php if (isset($medias)&& count($medias)>0){ ?>
<h4 class="text-center">{{$uModelName}} Attachments</h4>
<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
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
                    <div>
                        <a href="{{url()->current()}}/{{$media->id}}" class="b-n b-n-r bg-transparent item-download" data-wenk="Download">
                            <i class="fa fa-download text-primary"></i>
                        </a>
                        <a href="{{url()->current()}}/{{$media->id}}/detach" class="b-n b-n-r bg-transparent item-detach" data-wenk="Remove">
                            <i class="glyphicon glyphicon-remove text-danger"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<?php
}else{
?>
    <p class="text-center">There are no {{$uModelName}} Attachments</p>
<?php
}
?>