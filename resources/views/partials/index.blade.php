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

            var oldVal, $mainButton;

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

            window.pipelines =  function (id, event) {
                window.location.href = '{{url()->to("recruitment_requests")}}/' + id + '/stages';
            };

            window.updateStatus = function (id, status){
                //console.log('{{url()->to("recruitment_requests")}}/'+ id + '/'+ status + '/update-status');
                window.location.href = '{{url()->to("recruitment_requests")}}/'+ id + '/'+ status + '/update-status';
            }

            window.manageCandidate = function (id, event) {
                var route;
                route = '{{url()->current()}}/';

                loadUrl(route + id + '/manage-candidate');
            }
            
            window.pipelineSwitchState = function (id, event, candidate, newState) {
                var route = '{{url()->current()}}/';

                if (id) {
                    loadUrl(route + id + '/switch/' + candidate + '/' + newState);
                }
            };

            window.editEmployeeHistoryForm = function(id, event) {
                if (id) {
                    loadUrl('{{url()->current()}}/employee-history');
                }
            };

            window.addForm = function(event, baseUrl) {
                var route;
                if (baseUrl === void 0) {
                    route = '<?php echo e(url()->current()); ?>/';
                } else {
                    route = '<?php echo e(URL::to('/')); ?>/' + baseUrl + '/';
                }

               loadUrl(route + 'create');
            };

            window.addFormType = function(event,type_id,desc, baseUrl) {
                var route;
                if (baseUrl === void 0) {
                    route = '<?php echo e(url()->current()); ?>/';
                } else {
                    route = '<?php echo e(URL::to('/')); ?>/' + baseUrl + '/';
                }

                loadUrl(route + 'create/'+ type_id +'/'+ desc);
            };


            window.editFormAssessment = function(id, event, emp_id) {
                var route;
                route = '{{url()->current()}}/';

                if (id) {
                    @if (isset($fullPageEdit) && $fullPageEdit == TRUE)
                        window.location = route + id + '/employee/'+ emp_id + '/editAssessment';
                    @else
                    //$mainButton = $('.buttons button[type="submit"]');
                    loadUrl(route + id + '/employee/'+ emp_id + '/editAssessment');
                    @endif
                }
            };

            window.editFullPageAssessment = function(id, event, emp_id) {
                event.preventDefault();
                var route;
                route = '{{url()->current()}}/';
                window.location = route + id + '/employee/'+ emp_id + '/editAssessment';
            };

            window.editCloneAssessment = function(id, event) {
                loadUrl('{{url()->to('assessments')}}/assessment/'+id+'/cloneForm');
            };

            window.previewAssessment = function(id, event) {
                loadUrl('{{url()->to('assessments')}}/assessment/'+id+'/preview');
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

            window.showScoreModal = function (id,evaluationid,event)
            {
                loadUrl('{{url()->to('evaluations')}}/'+id+'/score/'+evaluationid+'/show-score-modal');
            }

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