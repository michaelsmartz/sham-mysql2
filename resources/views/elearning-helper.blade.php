@extends('portal-index')

@section('title','E-learning')
@section('content')
    <link href="{{URL::to('/')}}/css/hopscotch.min.css" rel="stylesheet">

    <section id="elearning-helper-section">
        <div class="row">
            <div class="col-xs-12">
                <h4>Hello there!</h4>
                <p>Are you new to e-learning? If so, this section is a must read.</p>
                <p>The following <strong>graphical workflow</strong> outlines the steps required to make a course available to the learner</p>
            </div>
            <div class="col-xs-12" id="t2">
                <div class="stepwizard">
                    <div class="stepwizard-row">
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-default btn-circle" data-step-index="2" >1</button>
                            <p>Course</p>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-default btn-circle" data-step-index="3" >2</button>
                            <p>Module(s)</p>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-default btn-circle" data-step-index="4" >3</button>
                            <p>Topic(s) <br>including <br>attachments <br>and content</p>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-default btn-circle" data-step-index="7" >4</button>
                            <p>Assessment(s)</p>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-default btn-circle" disabled="disabled">5</button>
                            <p>Course is <br>ready</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <p class="text-justify"><strong>Modules</strong> and <strong>topics</strong> are created as independent units.  They can be grouped in a desired sequence to be presented to the learner. This separate, independent approach also allows modules and topics to be reused as part of another course.</p>
                <p>You may click <a class="btn btn-success btn-md" href="{{URL::to('/')}}/courses">here</a> to go to the courses page</p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12">

            </div>
        </div>
        <div class="row">

        </div>
    </section>

    <script src="{{URL::to('/')}}/plugins/hopscotch/hopscotch-0.3.1.min.js"></script>
    <script src="{{URL::to('/')}}/plugins/hopscotch/e-learning-tour.js"></script>

@stop