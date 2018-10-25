<style>

    .reveal .controls{bottom:-10px!important}
    .navigate-down{display:none}
    .navigate-down.enabled{display:block!important}
    .navigate-down .enabled{display:block!important}
    .navigate-up{display:none}
    .navigate-up.enabled{display:block!important}
    .navigate-up .enabled{display:block!important}
    .topicsection[data-state] .reveal .controls{display:block}
    .reveal .controls .enabled{opacity:.7!important}
    .topicsection{height:90%;width:100%;overflow:hidden;position:relative}
    .topic{margin-bottom:5px!important;padding-bottom:5px!important;overflow-y:scroll;position:absolute;top:0;bottom:0;left:0;right:0}
    .topic > p.video > video{display:block;margin:0 auto!important;padding-bottom:65px!important}
    .reveal .slides section .fragment{visibility:visible!important}
    .present .photo-panel img{display:inline-block;object-fit:contain!important;height:50%;max-width:100%;overflow:hidden}
    .example{float:right;padding-right:300px;padding-top:50px;display:none}
    .dropbtn{background-color:#42affa;color:#fff;padding:8px;font-size:20px;border:none;cursor:pointer;position:absolute;left:400px;margin-top:10px}
    .dropbtn:hover,.dropbtn:focus{background-color:#3e8e41}
    .dropdown{position:absolute;display:inline-block}
    .dropdown-content{display:none;position:absolute;background-color:#f9f9f9;min-width:160px;box-shadow:0 8px 16px 0 rgba(0,0,0,0.2);top:47px;left:400px}
    .dropdown-content > a{color:#000!important;padding:8px 16px!important;text-decoration:none;display:block;font-size:14px!important}
    .dropdown-content a:hover{background-color:#f1f1f1;cursor:pointer}
    .show{display:block}
    .hide{display:none}
    .scrollable{overflow-y:auto!important;overflow-x:hidden!important;height:600px}
    video{height:calc(95% - 20px);width:98%!important;object-fit:fill;overflow:hidden}
    video::-webkit-media-controls-enclosure{overflow:hidden;/*position:absolute;bottom:-32px*/}
    video::-webkit-media-controls-panel{display:flex!important;opacity:1!important}
    video::-internal-media-controls-download-button{display:none}
    video::-webkit-media-controls-panel{width:calc(100% + 30px)}
</style>
<link rel="preload" href="{{URL::to('/')}}/audio/0.0.ogg" as="audio">
<script>
    /*!
     * screenfull
     * v3.3.2 - 2017-10-27
     * (c) Sindre Sorhus; MIT License
     */
    !function(){"use strict";var a="undefined"!=typeof window&&void 0!==window.document?window.document:{},b="undefined"!=typeof module&&module.exports,c="undefined"!=typeof Element&&"ALLOW_KEYBOARD_INPUT"in Element,d=function(){for(var b,c=[["requestFullscreen","exitFullscreen","fullscreenElement","fullscreenEnabled","fullscreenchange","fullscreenerror"],["webkitRequestFullscreen","webkitExitFullscreen","webkitFullscreenElement","webkitFullscreenEnabled","webkitfullscreenchange","webkitfullscreenerror"],["webkitRequestFullScreen","webkitCancelFullScreen","webkitCurrentFullScreenElement","webkitCancelFullScreen","webkitfullscreenchange","webkitfullscreenerror"],["mozRequestFullScreen","mozCancelFullScreen","mozFullScreenElement","mozFullScreenEnabled","mozfullscreenchange","mozfullscreenerror"],["msRequestFullscreen","msExitFullscreen","msFullscreenElement","msFullscreenEnabled","MSFullscreenChange","MSFullscreenError"]],d=0,e=c.length,f={};d<e;d++)if((b=c[d])&&b[1]in a){for(d=0;d<b.length;d++)f[c[0][d]]=b[d];return f}return!1}(),e={change:d.fullscreenchange,error:d.fullscreenerror},f={request:function(b){var e=d.requestFullscreen;b=b||a.documentElement,/ Version\/5\.1(?:\.\d+)? Safari\//.test(navigator.userAgent)?b[e]():b[e](c&&Element.ALLOW_KEYBOARD_INPUT)},exit:function(){a[d.exitFullscreen]()},toggle:function(a){this.isFullscreen?this.exit():this.request(a)},onchange:function(a){this.on("change",a)},onerror:function(a){this.on("error",a)},on:function(b,c){var d=e[b];d&&a.addEventListener(d,c,!1)},off:function(b,c){var d=e[b];d&&a.removeEventListener(d,c,!1)},raw:d};if(!d)return void(b?module.exports=!1:window.screenfull=!1);Object.defineProperties(f,{isFullscreen:{get:function(){return Boolean(a[d.fullscreenElement])}},element:{enumerable:!0,get:function(){return a[d.fullscreenElement]}},enabled:{enumerable:!0,get:function(){return Boolean(a[d.fullscreenEnabled])}}}),b?module.exports=f:window.screenfull=f}();
</script>
<section data-state="starter" data-lastslideofcourse="" data-lastslideoftopic="" data-displaynavtext="" data-course="" data-topic="" data-topichasassessment="" data-assessmentid="">
    <p >Please click on the <strong>blue arrow</strong> at the <strong>bottom right</strong> of the page below to start</p>
    <audio data-src="{{URL::to('/')}}/audio/0.0.ogg" autoplay="autoplay"></audio>
</section>

<?php if (isset($topics) && count($topics)>0): ?>
@foreach($topics as $module_topics)
    @foreach($module_topics as $topic)
        @foreach($topic->sections as $section)
            {!! $section !!}
        @endforeach
        @if(!empty($topic->assessments))
            <?php
            $count = count($topic->assessments);
            $counter = 0;
            ?>
            @foreach($topic->assessments as $key=>$assessment)
                <?php
                $counter = $counter+1;
                ?>
                @if($assessment)
                    @if($topic->LastTopic && $counter == $count)
                        <section data-state="slideCustomEvent" data-course="{{$courseId}}" data-module="" data-assessment="true" data-assessmentid="{{$key}}" data-topic=""
                                 class="topicsection" data-topichasassessment=""  data-islasttopic="" data-lastelement="true" data-lastslideoftopic="1" data-displaynavtext="">
                            <audio class="assessment-audio" data-src="{{url("/").'/audio/assessment.ogg'}}"></audio>
                            <div class="assessment-container"></div>
                        </section>
                    @else
                        <section data-state="slideCustomEvent"  data-course="{{$courseId}}" data-module="" data-assessment="true" data-assessmentid="{{$key}}" data-topic=""
                                 class="topicsection" data-topichasassessment="" data-islasttopic="" data-lastelement="false" data-lastslideoftopic="1" data-displaynavtext="">
                            <audio class="assessment-audio" data-src="{{url("/").'/audio/assessment.ogg'}}"></audio>
                            <div class="assessment-container"></div>
                        </section>
                    @endif
                @endif
            @endforeach
        @endif
    @endforeach
@endforeach
<?php endif; ?>


<script>
    /* When the user clicks on the button,
     toggle between hiding and showing the dropdown content */

    function myFunction(event) {
        // console.log();
        event.preventDefault();
        //console.log('My Function clicked...');
        //document.getElementById("myDropdown").classList.toggle("show");
        // document.getElementsByClassName("dropdown-content").classList.toggle("show");

        var element = document.getElementsByClassName('dropdown-content');
        for(var i = 0; i < element.length; i++)
        {
            element[i].classList.toggle("show");
            //console.log(element[i].className);
        }
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }

    ;(function () {

        function scaleImage(img) {
            if(img.isScaled) return;
            img.style.background="no-repeat url("+ img.src +") 50%";
            img.style.backgroundSize="contain";  // Use "contain", "cover" or a % value
            img.style.width="100%";
            img.style.height="100%";
            img.isScaled=true; // Prevent triggering another onload on src change
            img.src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
        }

        function parseAudio(topicSection) {
            var pureJ = topicSection.querySelectorAll('p.audio');
            if(pureJ.length > 0) {
                //var audio = document.createElement("audio");
                for (var i = 0; i < pureJ.length; i++) {
                    /*var audio = document.createElement("audio");
                     audio.setAttribute('controls','');
                     var source = document.createElement('source');
                     source.src = pureJ[i].innerHTML;
                     audio.appendChild(source);*/

                    pureJ[i].setAttribute('data-audio-src', strip(pureJ[i].getAttribute('data-url')));
                    if(i == pureJ.length-1) {
                        //data-audio-advance(wih positive value) will automatically move to next slide/fragment
                        //if the current page has video, the person has the chance of viewing it
                        pureJ[i].setAttribute('data-audio-advance', '-1');
                    } else {
                        pureJ[i].setAttribute('data-audio-advance', '2500');
                    }
                    //audio.setAttribute('data-audio-src', strip(pureJ[i].innerHTML));
                    pureJ[i].className += ' fragment visible';
                    pureJ[i].innerHTML = '&nbsp;&nbsp;&nbsp;';
                }
            }
        }

        function makeVideoFullScr(topicSection) {
            var pureJ = topicSection.querySelectorAll('video');
            if (pureJ.length > 0) {
                for (var i = 0; i < pureJ.length; i++) {
                    pureJ[i].setAttribute('onclick', 'screenfull.toggle(this)');
                }
            }
        }

        function parseVideo(topicSection) {
            var pureJ = topicSection.querySelectorAll('p.video');
            if (pureJ.length > 0) {
                topicSection.setAttribute('data-state','media');
                for (var i = 0; i < pureJ.length; i++) {
                    var video = document.createElement("video");
                    //console.log(pureJ[i].innerHTML);
                    // setting data-audio-controls with audio-slideshow allows control of it with the
                    // controls at the bottom of the page
                    video.setAttribute('src', strip(pureJ[i].getAttribute('data-url')));
                    video.setAttribute('preload', 'auto');
                    video.setAttribute('controls', '');

                    // hide the video text link which is a paragraph
                    pureJ[i].innerHTML = '';
                    pureJ[i].appendChild(video);
                }
            }
        }

        function parseOthers(topicSection) {
            var pureJ = topicSection.querySelectorAll('p.others');
            //console.log(topicSection);
            //console.log("Length:" + pureJ.length);

            if (pureJ.length > 0) {

                // var ullist = document.getElementsByClassName('dropdown-content');
                //parent.querySelector('.topic');
                var ullist = topicSection.querySelector('.dropdown-content');
                //console.log(ullist1);

                for (var i = 0; i < pureJ.length; i++) {
                    //var ulelement = document.createElement("Li");
                    var aelement = document.createElement("a");
                    var topicattachmentid = pureJ[i].getAttribute('data-attachmentid');

                    aelement.setAttribute('data-attachmentid',topicattachmentid);
                    aelement.addEventListener("click", clickHandler);

                    var urlpath = strip(pureJ[i].getAttribute('data-url'));//url.substring(url.lastIndexOf('/')+1, url.length)
                    urlpath = urlpath.substring(urlpath.lastIndexOf('/')+1, urlpath.length);

                    aelement.innerHTML = urlpath;
                    ullist.appendChild(aelement);

                    pureJ[i].innerHTML = '';
                }

                var a = document.querySelectorAll(".embed-link");
                for(var i=0; i < a.length; i++){
                    a[i].addEventListener("click", clickHandler);
                }
            }
            else
            {
                // document.getElementById("dropdown").classList.toggle("hide");
                topicSection.querySelector('.dropdown').classList.toggle("hide");
                // document.getElementsByName("dropdown").classList.toggle("hide");
            }
        }

        function checkFragments(topicSection) {
            var ts = topicSection.querySelectorAll('.fragment');
            if (ts.length > 0) {
                topicSection.setAttribute('data-state', 'fragmented');
            }
        }

        function checkAssessment(topicSection) {
            var ts = document.querySelectorAll('.topicsection');
            if (ts.length > 0) {
                for (var i = 0; i < ts.length; i++) {
                    var attribname = ts[i].getAttribute('data-assessment');
                    if (attribname == true) {
                        var container = ts[i].querySelector('.assessment-container');
                        var formDiv = document.createElement("div");
                        formDiv.setAttribute('data-form', 'true');
                        container.appendChild(formDiv);
                    }
                }
            }

            /*for (var i = 0; i < ts.length; i++) {
             //console.log(ts[i]);
             }*/
            // var attrib = ts[0].getAttribute('data-has-assessment');
            // alert(attrib);
            /*console.log("Check assessment");
             var st = topicSection.getAttribute('data-assessment');
             console.log("Check assessment before st log");
             console.log(st);
             if (st == 'true' || st == true) {
             console.log("In topic check assessment  ");
             var container = topicSection.querySelector('.assessment-container');
             var formDiv = document.createElement("div");
             formDiv.setAttribute('data-form', 'true');
             container.appendChild(formDiv);
             }*/
        }

        var clickHandler = function (e){
            e.preventDefault();
            // var attachmentId = this.getAttribute("data-attachmentid");
            // console.log(attachmentId);

            var id =  this.getAttribute("data-attachmentid");
            window.location = '{{url("/")}}/topic-attachment/'+id+'/download';

        };

        var SfHandler = function(){
            screenfull.toggle( this );
        };

        function strip(html) {
            // remove html tags and return text
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }

        // make the presentation scrollable, but without showing the scrollbar
        var tsArr = document.querySelectorAll('.topicsection');
        if (tsArr.length > 0) {
            for (var i = 0; i < tsArr.length; i++) {

                var parent = tsArr[i];
                var child = parent.querySelector('.topic');
                if (child != null) {
                    child.style.right = child.clientWidth - child.offsetWidth + "px";
                }
                // parse audio, video and assessment
                var topicSection = document.querySelector('.topicsection');
                checkFragments(parent);
                makeVideoFullScr(parent);
                //parseAudio(parent);
                //parseVideo(parent);
                //parseOthers(parent);

                checkAssessment(topicSection);
            }
        }
    })();
</script>