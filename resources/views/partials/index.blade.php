<form method="POST" action="{{route($routeName, 'deleteId')}}" id="indexDeleteForm">
    <input type="hidden" name="id" id='deleteField'>
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
</form>

@section('post-body')
    <style>
        .alerty{ width: 500px !important;}
        .modal.fade.show{opacity:1 !important}
        .modal-inner footer {
            display: flex; justify-content: flex-end; align-items: center;
            padding: 10px 1.2em 18px !important;
        }
        .modal-close{
            border-radius: 4px 4px 0 0 !important;
        }
    </style>
    <script src="{{url('/')}}/js/tables.js"></script>
    <script src="{{url('/')}}/plugins/html2canvas/html2canvas-1.0.0.a12.min.js"></script>
    <script src="{{url('/')}}/plugins/alerty/alerty.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/plugins/alerty/alerty.min.css">
    <script>
        var oldVal, $mainButton, loadUrl = function (url) {
            $mainButton = $('.buttons button[type="submit"]');
            $mainButton.button('loading');
            $.get(url).done(function (data) {
                $("#modal-label h2").empty().html(data.title);
                $(".modal-content").empty().html(data.content);
                $(".modal-inner .buttons").empty().html(data.footer);
                $mainButton.button('reset');
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
            event.preventDefault();
            if (id) {
                @if (isset($fullPageEdit) && $fullPageEdit == 'true')
                console.log('yes ' + id);
                window.location = '{{url()->current()}}/'+id+'/edit';
                @else
                console.log('no ' + id);
                $mainButton = $('.buttons button[type="submit"]');
                $mainButton.button('loading');
                loadUrl('{{url()->current()}}/'+id+'/edit');
                @endif
            }
        }

        {{--function attachForm(id, event) {--}}
            {{--if (id) {--}}
                {{--alert(id);--}}
                {{--$('#md-content').empty().load('{{url()->to('medias')}}/'+id+'/attachment' ,function(response, status){--}}
                    {{--statusModalToggle(status);--}}
                {{--});--}}
            {{--}--}}
        {{--}--}}

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
    </script>

@endsection