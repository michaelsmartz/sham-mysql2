<form method="POST" action="{{route($routeName, 'deleteId')}}" id="indexDeleteForm">
    <input type="hidden" name="id" id='deleteField'>
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
</form>

@section('post-body')
    <style>
        .alerty{ width: 500px !important;}
    </style>
    <script src="{{url('/')}}/js/tables.js"></script>
    <script src="{{url('/')}}/plugins/html2canvas/html2canvas-1.0.0.a12.min.js"></script>
    <script src="{{url('/')}}/plugins/alerty/alerty.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/plugins/alerty/alerty.min.css">
    <script>

        var oldVal, $mainButton, loadUrl = function (url) {
            $.get(url).done(function (data) {
                $(".light-modal-heading").empty().html(data.title);
                $(".light-modal-body").empty().html(data.content);
                $(".light-modal-footer .buttons").empty().html(data.footer);
                $("#modalForm").attr('action',data.url);

                $('.multipleSelect').each(function(){
                    $(this).multipleSelect({ filter: true });
                });
            });
        };

        $('#item-create,.item-create').click(function() {
            window.location = '{{url()->current()}}/create';
        });

        function statusModalToggle(status) {
            if (status == "success"){
                $('#md').modal('toggle');
            } else {
                $('#mde').modal('toggle');
            }
        }

        function editForm(id, event) {
            //event.preventDefault();
            if (id) {
                @if (isset($fullPageEdit) && $fullPageEdit == 'true')
                    window.location = '{{url()->current()}}/'+id+'/edit';
                @else
                    $mainButton = $('.buttons button[type="submit"]');
                    loadUrl('{{url()->current()}}/'+id+'/edit');
                @endif
            }
        }

        function editFullPage(id, event){
            event.preventDefault();
            window.location = '{{url()->current()}}/'+id+'/edit';
        }

        function deleteForm(id) {
            $("#deleteField").val(id);
            var oldVal = $("#indexDeleteForm").attr("action");
            $("#indexDeleteForm").attr("action", $("#indexDeleteForm").attr("action").replace('deleteId', id));

            html2canvas(document.getElementById('tr'+id), {logging:false,width:400}).then(function(canvas) { cp(canvas); }); // here send canvas to cp
            var cp = function(canvas) {
                var image = canvas.toDataURL("image/png");

                alerty.confirm(
                        "Are you sure to <strong class='text-danger'>delete</strong> this record?<br>" +
                        "<img style='object-fit: cover;' src='"+image + "'>",
                        {   title: '@yield("title")',
                            okLabel: '<span class="text-danger">Yes</span>',
                            cancelLabel: 'No'
                        },
                        function() {
                            // ok callback
                            $("#indexDeleteForm").submit();
                        },
                        function() {
                            $("#indexDeleteForm").attr("action", oldVal);
                        }
                )
            };

        }

        function deleteAttachment(fileName, id, mediaId){
            //event.preventDefault();
            alerty.confirm(
                "Are you sure to <strong class='text-danger'>delete</strong> file  <strong class='text-danger'>"+fileName+"</strong>?<br>",
                {
                    okLabel: '<span class="text-danger">Yes</span>',
                    cancelLabel: 'No'
                },
                function() {
                    //ok callback
                    window.location = '{{url()->current()}}/'+id+'/attachment/'+mediaId+'/detach';
                }
            )
        }

    </script>

@endsection