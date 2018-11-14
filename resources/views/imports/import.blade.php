@extends('portal-index')
@section('title','Import data')

@section('content')
    {{-- 
    <div class="row">

        <div class="col-xs-12">
            <section>
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" data-wenk="Step 1">
                                    <span class="round-tab">
                                        <i class="fa fa-download"></i>
                                    </span>
                                </a>
                                <div class="caption hidden-xs hidden-sm">Step <span>1</span>: <span>Download the Template</span></div>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" data-wenk="Step 2">
                                    <span class="round-tab">
                                        <i class="fa fa-clone"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#complete" data-toggle="tab" aria-controls="step3" role="tab" data-wenk="Complete">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form role="form" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div class="tab-pane active" role="tabpanel" id="step1">
                                <h3>Step 1</h3>
                                <p>This is step 1</p>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <div class="step2">
                                    <div class="step_21">
                                        <div class="row">
                                            <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                                <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>

                                                <div class="col-md-6">
                                                    <input id="csv_file" type="file" class="form-control" name="csv_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>

                                                    @if ($errors->has('csv_file'))
                                                        <span class="help-block">
                                                        <strong>{{ $errors->first('csv_file') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-4">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="header" checked> File contains header row?
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-8 col-md-offset-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Parse CSV
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                    <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step3">
                                <h3>Complete</h3>
                                <p>You have successfully completed all steps.</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    --}}

    <div class="row">
        <div class="col-xs-12">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step col-xs-4"> 
                        <a href="#step-1" type="button" class="btn btn-success btn-circle"><i class="fa fa-download"></i></a>
                        <p><small>Step <span>1</span>: <span>Download the Template</span></small></p>
                    </div>
                    <div class="stepwizard-step col-xs-4"> 
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-clone"></i></a>
                        <p><small>Map Columns</small></p>
                    </div>
                    <div class="stepwizard-step col-xs-4"> 
                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-check"></i></a>
                        <p><small>Import Results</small></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <form role="form" name="import_form" id="import_form" role="form" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input name="header" type="hidden" value="1">
                <div class="panel panel-primary setup-content" id="step-1">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-download"></i> Step <span>1</span>: <span>Download the Template</span></h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <p>You may click <a href="{{asset('Sham_Employees_Import_Template.xlsx')}}" class="text-primary">here</a> to download the Excel template file.</p>
                            <p><strong class="text-danger">Note: </strong>Required columns are marked with an <label class="text-danger">&lowast;</label>.Please fill a copy of the above template file with the data to import and upload it when you are ready</p>
                        </div>
                        <div class="form-group {{ $errors->has('attachment') ? 'has-error' : '' }}">
                            @include('partials.uploader',[
                                'route' => 'import.store',
                                'uploader' => $uploader,
                                'multiple' => ''
                            ])
                        </div>
                        <button class="btn btn-primary pull-right" type="submit">Next</button>
                    </div>
                </div>
            </form>

                <div class="panel panel-primary setup-content" id="step-2">
                    <div class="panel-heading">
                        <h3 class="panel-title">Destination</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">Company Name</label>
                            <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Name" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Company Address</label>
                            <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Address" />
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Previous</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                        
                    </div>
                </div>
                
                <div class="panel panel-primary setup-content" id="step-3">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cargo</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">Company Name</label>
                            <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Name" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Company Address</label>
                            <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Address" />
                        </div>
                        <button class="btn btn-success pull-right" type="submit">Finish!</button>
                    </div>
                </div>
            
        </div>
    </div>

@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/css/import_steps.min.css">
<script>
    $(document).ready(function () {
        
        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allPrevBtn = $('.prevBtn'),
            allNextBtn = $('.nextBtn');

        allWells.hide();
        
        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-success').addClass('btn-default');
                $item.addClass('btn-success');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });
        
        allNextBtn.click(function () {
            /*
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
            */
        });
        

        allPrevBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

            prevStepWizard.removeAttr('disabled').trigger('click');
        });
        

        $('div.setup-panel div a.btn-success').trigger('click');
        
    });

</script>
@append