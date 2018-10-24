@extends('portal-index')
@section('title','My E-learning')
@section('post-body')
    <link href="{{URL::to('/')}}/css/nicescroll.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/plugins/embedjs/embed.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/plugins/plyrjs/plyr.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/plugins/reveal.js/css/reveal.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/self-service-portal.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/plugins/reveal.js/css/theme/black.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/topic-renderer.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/plugins/jquery-dropdown-master/jquery.dropdown.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--
    <script src="{{URL::to('/')}}/document-library/libs/pdfjs/pdf.js"></script>
    -->
    <script src="{{URL::to('/')}}/plugins/plyrjs/plyr.js"></script>
    <script src="{{URL::to('/')}}/plugins/embedjs/embed.min.js"></script>
    <script src="{{URL::to('/')}}/plugins/reveal.js/lib/js/head.min.js"></script>
    <script src="{{URL::to('/')}}/plugins/reveal.js/reveal.js"></script>
    <script>
        var $ = jQuery.noConflict();
    </script>
    <script src="{{URL::to('/')}}/plugins/Formbuilder/js/dust-full.min.js"></script>
    <script src="{{URL::to('/')}}/plugins/Formbuilder/js/formrunner.js"></script>
    <script src="{{URL::to('/')}}/plugins/jquery-dropdown-master/jquery.dropdown.js"></script>
    <script>

        $(function () {
            var totalSlides, currentSlide;
            // set up jQuery with the CSRF token, or else post routes will fail
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

            function checkHandleAssessment() {
                //console.log( $('.present > div[data-form=true]') );
                //alert("Handle Assessments....");

                var el = Reveal.getCurrentSlide();
                if(el.getAttribute('data-assessment')==true || el.getAttribute('data-assessment')=='true')
                {
                    var myForm;
                    var assessment = '{!! $assessmentData !!}';
                    var courseid = el.getAttribute('data-course');
                    var assessmentid = el.getAttribute('data-assessmentid');
                    var status = el.getAttribute('data-lastelement');

                    var assessmentdata="";
                    console.log(assessmentdata);

                    //alert(assessmentdata);
                    //$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

                    $('.assessment-audio').get(0).currentTime = 0;
                    $('.assessment-audio').get(0).play();

                    var url = '{{url()->to('my-courses')}}/'+assessmentid+'/getAssessmentData';
                    console.log(url);

                    var data1  = "";
                    var request = jQuery.ajax({
                        url: url,
                        type: "GET",
                        global: false,
                        data: { },
                        dataType: 'JSON',
                        beforeSend: function() {
                            $("#assessment-progress-info").removeClass('hide');
                        },
                        success: function (data) {
                            console.log(data);
                            assessment = data;

                            if (assessment != 'null' && assessment != '') {
                                console.log("In...");

                                var jsonObj = assessment;//jQuery.parseJSON(assessment);
                               // alert('In iff');

                                console.log($('.present > div.assessment-container'));

                                var frOptions = {
                                    templateBasePath: '{{URL::to('/')}}/js/Formbuilder/v2/templates/runner',
                                    targets: $('.present > div.assessment-container'),
                                    form_id:  jsonObj.form_id,
                                    model: jsonObj.model,
                                    action: '{{URL::to('/')}}/my-courses/'+courseid+'/assessment/'+assessmentid+'/post/'+status //'./2030/assessment/1020/post'
                                };

                                jQuery('.slide-menu-button').hide();
                                jQuery('.progress').hide();
                                $("#assessment-progress-info").addClass('hide');
                                // Create an instance of form builder
                                myForm = new Formrunner(frOptions);
                                // formrunner fb-runner-rendered event will trigger when form is rendered
                            }
                        }
                    });
                }
            }

            function postProgress(el) {
                //console.log('postProgress ' + el.getAttribute('data-course') + ' '+ el.getAttribute('data-topic'));
                var datacourse, datatopic, datahasassessment;

                //datacourse = el.parentNode.parentNode.parentNode.getAttribute('data-course');
                //datatopic = el.parentNode.parentNode.parentNode.getAttribute('data-topic');
                //datahasassessment = el.parentNode.parentNode.parentNode.getAttribute('data-topichasassessment');

                datacourse = el.closest(".topicsection").getAttribute('data-course');
                datatopic = el.closest(".topicsection").getAttribute('data-topic');
                datahasassessment = el.closest(".topicsection").getAttribute('data-topichasassessment');

                if (datacourse !='' && datatopic != '') {
                    //alert(el.parentNode.parentNode.parentNode.getAttribute('class'));
                    var request = jQuery.ajax({
                        url: '{{URL::to('/')}}/my-courses/progress',
                        type: "POST",
                        global: false,
                        data: {
                            'courseId': datacourse, 'topicId': datatopic, 'topicHasAssessment':datahasassessment
                        }
                    });
                    return request;
                }
                return false;
            }

            function attachmentLink(id,e)
            {
                e.preventDefault();

                window.location = '{{url("/")}}/topic-attachment/'+id+'/download';
            }

            Reveal.initialize({
                // Optional libraries used to extend on reveal.js
                controls: false,
                keyboard: false,
                loop: false,
                mouseWheel: false,
                scroll: true,
                // Number of milliseconds between automatically proceeding to the
                // next slide, disabled when set to 0, this value can be overwritten
                // by using a data-autoslide attribute on your slides
                autoSlide: 0,
                fragments: true,
                center: false,

                // Stop auto-sliding after user input
                autoSlideStoppable: true,
                // Use this method for navigation when auto-sliding
                //autoSlideMethod: Reveal.navigateNext,
               /* audio: {
                    prefix: '',
                    suffix: '',
                    defaultDuration: 5,
                    textToSpeechURL: "http://api.voicerss.org/?key=50b630533dde4ab4b2ae077a783f8ebc&hl=en-gb&c=ogg&src=",
                    advance: -1,
                    autoplay: true,
                    defaultNotes: false,
                    defaultText: false,
                    playerOpacity: 0.2,
                }, */
                dependencies: [
                    { src: '{{URL::to('/')}}/plugins/reveal.js/plugin/menu/reveal-menu.js' },
                   /* { src: '{{URL::to('/')}}/plugins/reveal.js/plugin/audio-slideshow/audio-slideshow.js', condition: function( ) { return !!document.body.classList; } },*/
                ],
                menu: {
                    hideMissingTitles: true,
                    transitions: false,
                    themes: false,
                    side: 'left',
                    keyboard: false,
                    custom: [
                        { title: 'Action', icon: '<i class="fa fa-external-link">', src: '{{URL::to('/')}}/links.html' },
                        { title: 'Attachments', icon: '<i class="fa fa-external-link">', content: '<div class="attachmentlist"></div>' }
                    ]
                },
                width: "100%",
                height: "100%",
                transition: 'slide',
                margin: 0,
                minScale: 1,
                maxScale: 1
            });

            totalSlides = Reveal.getTotalSlides();
            sessionStorage.completedSlideIndex = 0;

            Reveal.addEventListener('slidechanged', function( event ) {
            // event.previousSlide, event.currentSlide, event.indexh, event.indexv
            var el;
            //console.log('slidechanged: ' + event.indexh);

            if (event.indexh == 1) {
                el = event.currentSlide;
            } else {
                el = event.previousSlide;
            }

            var stateData = $('.present').data('state');
            var hasFragments = false;
            if (stateData == "fragmented") {
                hasFragments = true;
            }

            if (hasFragments == true) {
                $('.navigate-down').css({'display':'block'}).addClass('enabled');
                $('.navigate-up').css({'display':'block'}).addClass('enabled');
            } else {
                $('.navigate-down').css({'display':'none'}).removeClass('enabled');
                $('.navigate-up').css({'display':'none'}).removeClass('enabled');
            }

            //var lastslideoftopic = el.parentNode.parentNode.parentNode.getAttribute('data-lastslideoftopic');
            var lastslideoftopic = el.closest(".topicsection").getAttribute('data-lastslideoftopic');
            var assessmentid = el.closest(".topicsection").getAttribute('data-assessmentid');
            //var navtext = el.closest(".topicsection").getAttribute('data-displaynavtext');
            var navtext =  event.currentSlide.closest(".topicsection").getAttribute('data-displaynavtext');
            $('#naviagationtext').text(navtext);


            // Code below Populate the attachments for the topic in the Menu
            var topicid = el.closest(".topicsection").getAttribute('data-topic');
            if(topicid != '')
            {
                var url = '{{url()->to('my-courses')}}/'+topicid+'/getattachments';
                var request = jQuery.ajax({
                    url: url,
                    type: "GET",
                    global: false,
                    data: { },
                    dataType: 'JSON',
                    success: function (data) {
                        $(".attachmentlist").empty();
                        for(var i = 0; i < data.length; i++) {
                            var obj = data[i];
                            var attachmentLink = '{{url("/")}}/topic-attachment/'+ obj.Id +'/download';
                            $('.attachmentlist').append("<p class='attachment'><a href='"+ attachmentLink +"'>"+obj.OriginalFileName+"</a></p>");
                        }
                    }
                });
            }

            if((lastslideoftopic == 1 && event.indexh > 1 && event.indexh > sessionStorage.completedSlideIndex )||assessmentid != '')
            {
                postProgress(el);
                checkHandleAssessment();
            }
            sessionStorage.completedSlideIndex = event.indexh;

            var state = Reveal.getState();
            Reveal.setState( state );

        });

            Reveal.addEventListener( 'media', function(e) {
                // Called each time the slide with the "assessment" state is made visible
                // console.log(e);
                //checkHandleAssessment();
            });

            $('.navigate-next').click(function() {
                currentSlide = Reveal.getIndices().h;
                //console.log('Next link clicked:' + currentSlide + ' ' + totalSlides);
                var el = Reveal.getCurrentSlide();
                //var lastslideofCourse = el.parentNode.parentNode.parentNode.getAttribute('data-lastslideofcourse');
                var lastslideofCourse = el.closest(".topicsection").getAttribute('data-lastslideofcourse');

                //if (currentSlide == totalSlides-1) {
                if (el.getAttribute('data-lastslideofcourse') != null) {
                    lastslideofCourse = el.getAttribute('data-lastslideofcourse');
                }

                if (lastslideofCourse == "1") {
                    $(".navigate-prev, .navigate-next, .navigate-up, .navigate-down").hide();
                    $("#alert").removeClass('hide');
                    var request = postProgress(el);
                    request.done(function (msg) {
                        window.location.href = '{{URL::to('/')}}/my-courses#mycourse';
                    });
                    //window.location.href = '{{URL::to('/')}}/my-courses';
                }
                // Update progress of first slide
                if(el.indexh == 1)
                {
                    postProgress(el);
                    checkHandleAssessment();
                }
            });

            Reveal.addEventListener( 'menu-ready', function( event ) {

                document.getElementsByClassName('slide-menu-toolbar')[0].removeChild(document.getElementsByClassName('slide-menu-toolbar')[0].getElementsByTagName('li')[0]);
                var elements = document.getElementsByClassName('slide-menu-items')[0].getElementsByTagName('li');
                while(elements.length > 0){
                    elements[0].parentNode.removeChild(elements[0]);
                }
            } );


            Reveal.addEventListener( 'slideCustomEvent', function( event ) {
                $(".navigate-prev, .navigate-next, .navigate-down, .navigate-up").hide();
            });

            $(window).on('fb-runner-rendered', function() {
                // the form is rendered, we append a CSRF token to it
                // needed to allow form to submit successfully
                $('<input>').attr({
                    type: 'hidden',
                    value: '{{ csrf_token() }}',
                    name: '_token'
                }).appendTo('.frmb-form');
            });
        });

        function closeForm()
        {
            window.location.href = '{{URL::to('/')}}/my-courses';
        }

    </script>
@stop
    <div id="naviagationtext"></div>

    <div id="alert" class="alert hide">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong></strong>Course completed. You will be redirected to My Elearning page shortly.
    </div>
    <div id="assessment-progress-info" class="alert hide">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong></strong>Loading Assessment. Please wait.
    </div>
    <div class="reveal">
        <div class="slides">
            {!! $dyn !!}
            {{--
            <section data-audio-text="Workplace Communication Skills trainers are empowered to teach the essential communication skills that will bring success in both the workplace and at home. The primary aim of this training course is to enable participants with an understanding of the impact that their communication skills can have on others, while exploring the different ways in which developing these skills can make it easier for them to succeed in the office and beyond.">
                <div>{!! $topic->Data !!}</div>
            </section>
            <section data-audio-src="http://localhost/topic-attachment/1/embed/Beyondthesea.mp3">
                <audio id="z1">
                    <source src="http://localhost/topic-attachment/1/embed/Beyondthesea.mp3">
                </audio>
                <video controls data-audio-controls>
                    <source src="http://localhost/topic-attachment/3/embed/SampleVideo_720x480_5mb.mp4">
                </video>
                bla bla bla, but testing audio with the audio-slideshow plugin
            </section>
            <section data-audio-src="">
                <div class="" data-has-assessment="true" id="form"></div>
            </section>
            --}}
        </div>
        <div id="indicators" class="row">
            <div class="my-controls">
                <a href="#" class="navigate-prev" title="Previous slide"><i class="fa fa-chevron-left"></i></a> <!-- Previous vertical or horizontal slide -->
                <a href="#" class="navigate-up" title="Next down"><i class="fa fa-chevron-up"></i></a> <!-- Next vertical or horizontal slide -->
                <a href="#" class="navigate-down" title="Next down"><i class="fa fa-chevron-down"></i></a> <!-- Next vertical or horizontal slide -->
                <a href="#" class="navigate-next" title="Next slide"><i class="fa fa-chevron-right"></i></a> <!-- Next vertical or horizontal slide -->

            </div>
        </div>
    </div>



