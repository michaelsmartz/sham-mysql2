@if(!empty($routeName))
<form method="POST" action="{{route($routeName, 'deleteId')}}" id="indexDeleteForm">
    <input type="hidden" name="id" id='deleteField'>
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
</form>
@endif

@push('js-stack')
    <style>
        .alerty{ width: 500px !important;}
    </style>
    <script src="{{url('/')}}/js/tables.min.js"></script>
    <script src="{{url('/')}}/plugins/html2canvas/html2canvas-1.0.0.a12.min.js" defer></script>
    <script src="{{url('/')}}/plugins/alerty/alerty.min.js" defer></script>
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/plugins/alerty/alerty.min.css">
    <script src="{{url('/')}}/plugins/multiselect/multiselect.min.js"></script>
    <script>
        (function mainIIFE($) {
            "use strict";

            var oldVal, $mainButton, loadUrl = function(url) {
                $(".light-modal-body").empty().html('Loading...please wait...');
                $.get(url).done(function(data) {
                    $(".light-modal-heading").empty().html(data.title);
                    $(".light-modal-body").empty().html(data.content);
                    $(".light-modal-footer .buttons").empty().html(data.footer);
                    $("#modalForm").attr('action',data.url);

                    cleanUrlHash();

                    $('.multipleSelect').each(function(){
                        $(this).multiselect({
                            submitAllLeft:false,
                            sort: false,
                            keepRenderingSort: false,
                            search: {
                                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                            },
                            fireSearch: function(value) {
                                return value.length > 3;
                            }
                        });
                    });
                }).fail(function() {
                    alerty.alert("An error has occurred. Please try again!",{okLabel:'Ok'});
                });
            };

            $('#item-create,.item-create').click(function() {
                var createUrl = $(this).data('create-url');
                if(createUrl === void 0){
                    window.location = '{{url()->current()}}/create';
                } else window.location = createUrl;
            });

            window.showTimeline = function(id, event) {
                window.location = '{{url()->to("timelines")}}/'+id;
            };
            window.showResponses = function(id, event) {
                window.location = '{{url()->to("module_assessments")}}/' + id + '/responses';
            };
            
            window.cleanUrlHash = function(){
                window.history.pushState(null, "", window.location.href.replace("#light-modal", ""));
                //history.replaceState(null, "", window.location.pathname);
                //return window.location.hash.replace(/^#/, '');
            };

            window.editEmployeeHistoryForm = function(id, event) {
                if (id) {
                    loadUrl('{{url()->current()}}/employee-history');
                }
            };

            window.editForm = function(id, event, baseUrl) {
                var route; 
                if (baseUrl === void 0) {
                    route = '{{url()->current()}}/';
                } else {
                    route = '{{URL::to('/')}}/' + baseUrl + '/';
                }

                if (id) {
                    @if (isset($fullPageEdit) && $fullPageEdit == TRUE)
                        window.location = route + id + '/edit';
                    @else
                        //$mainButton = $('.buttons button[type="submit"]');
                        loadUrl(route + id + '/edit');
                    @endif
                }
            };
            window.showForm = function(id, event) {
                $("#modalForm input[name='_method']").remove();
                if (id) {
                    @if (isset($fullPageShow) && $fullPageShow == TRUE)
                        window.location = '{{url()->current()}}/'+id;
                    @else
                        //$mainButton = $('.buttons button[type="submit"]');
                        loadUrl('{{url()->current()}}/'+id);
                    @endif
                }
            };
            window.matrixForm = function(id, event) {
                if (id) {
                    //$mainButton = $('.buttons button[type="submit"]');
                    loadUrl('{{url()->current()}}/'+id+'/matrix');
                }
            };
            window.generateResult = function(id, event) {
                event.preventDefault();
                if (id) {
                    window.location = '{{url()->current()}}/'+id+'/results';
                }
            };
            window.editFullPage = function(id, event, baseUrl) {
                event.preventDefault();
                var route; 
                if (baseUrl === void 0) {
                    route = '{{url()->current()}}/';
                } else {
                    route = '{{URL::to('/')}}/' + baseUrl + '/';
                }
                window.location = route + id + '/edit';
            };
            window.deleteForm = function(id) {
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
            };
            window.deleteAttachment = function(fileName, id, mediaId){
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
            };
        }(window.jQuery));
    </script>
@endpush