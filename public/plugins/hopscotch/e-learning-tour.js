/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */
var tour = {
  id: "hello-hopscotch",
  steps: [
    {
      title: "E-learning tour",
      content: "The first main element the learner will see is a <strong>course</strong>.  Clicking on the Next button below will take us to the Courses page where the trainer defines the course description and objectives.",
      target: "startTourBtn",
      placement: "bottom",
      xOffset: "center",
      arrowOffset: "center",
      width: 350,
      multipage: true,
      onNext: function() {
        window.location = "../courses"
      }
    }, // 1
    {
      title: "The Courses page",
      content: "To create <strong>a new course</strong>, you may click this button.<br>The learner will see one or more modules underneath a course.",
      target: "item-create",
      placement: "bottom",
      xOffset: "center",
      arrowOffset: "center",
      width: 350,
      multipage: true,
      onNext: function() {
        window.location = "../emodules"
      }
    }, //2
    {
      title: "The Modules page",
      content: "To create <strong>a new module</strong>, you may click this button.<br>The next but most important thing the learner will see is a topic or a series of topics that, in his/her perspective, make up the academic part of the course.",
      target: "item-create",
      placement: "bottom",
      xOffset: "center",
      arrowOffset: "center",
      width: 350,
      multipage: true,
      onNext: function() {
        window.location = "../topics"
      }
    }, //3
    {
      title: "The Topics page",
      content: "To create <strong>a new topic</strong>, you may click this button.",
      target: "item-create",
      placement: "bottom",
      xOffset: "center",
      arrowOffset: "center",
      width: 230
    }, //4
    {
      title: "The Topics page",
      content: "You may need to link audio, video or documents that will be available when the topics are shown to the learner. To do this, click on one of the <span class='btn btn-default btn-xs'><i class='glyphicon glyphicon-paperclip'></i></span> buttons to attach those files to that topic.",
      target: "topics-table-head",
      placement: "left",
      xOffset: "center",
      yOffset: "20",
      arrowOffset: "center",
      width: 230
    }, //5
    {
      title: "The Topics page",
      content: "Now that you have the topics attachments ready, the next main step is to design the topic content. To do this, click on one of the <span class='btn btn-default btn-xs'><i class='glyphicon glyphicon-pencil'></i></span> buttons to do so.",
      target: "topics-table-head",
      placement: "left",
      xOffset: "center",
      yOffset: "20",
      arrowOffset: "center",
      width: 230,
      multipage: true,
      onNext: function() {
        window.location = "../moduleassessments"
      }
    }, //6
    {
      title: "The Module Assessments page",
      content: "To create <strong>a new assessment</strong>, you may click this button.",
      target: "item-create",
      placement: "bottom",
      xOffset: "center",
      arrowOffset: "center",
      width: 230
    }, //7
    {
      title: "The Module Assessments page",
      content: "You created the basics of the Assessment; but now you'll need to actually set the questions. To do this, click on the <span class='btn btn-default btn-xs'><i class='glyphicon glyphicon-equalizer'></i></span> button for this.",
      target: "assessment-question-demo",
      placement: "left",
      xOffset: "0",
      arrowOffset: "center",
      width: 230
    }, //8
    {
      title: "The Module Assessments page",
      content: "At this point, you have all the individual units that make up a course.<br> Next, you will link the <strong>topics</strong> to the <strong>modules</strong> that you have already created.",
      target: "sec-moduleassessment",
      placement: "top",
      yOffset: "center",
      arrowOffset: "center",
      width: 230,
      multipage: true,
      onNext: function() {
        window.location = "../emodules"
      }
    }, //9
    {
      title: "The Modules page",
      content: "To link individual topics to a module, click on the <span class='btn btn-default btn-xs'><i class='glyphicon glyphicon-equalizer'></i></span> button of that module to do so.",
      target: "modules-table-head",
      placement: "left",
      xOffset: "center",
      yOffset: "20",
      arrowOffset: "center",
      width: 350,
      multipage: true,
      onNext: function() {
        window.location = "../courses"
      }
    }, //10
    {
      title: "The Courses page",
      content: "To link individual modules to a course, click on the <span class='btn btn-default btn-xs'><i class='glyphicon glyphicon-equalizer'></i></span> button of that module to do so.<br><br><strong>At this point, <span class='text-success'>the course is ready</span></strong>.",
      target: "courses-table-head",
      placement: "left",
      xOffset: "center",
      yOffset: "20",
      arrowOffset: "center",
      width: 350
    } //11
  ],
  onError: function() {
    console.log('error');
  }
};

var callouts = {
  steps: [
      {target: "", placement: "bottom"},
      {target: "item-create", placement: "bottom", xOffset: "0", arrowOffset: "center",
       url:"../courses", width: 200},
      {target: "item-create", placement: "bottom", xOffset: "0", arrowOffset: "center",
          url:"../emodules", width: 200},
      {target: "item-create", placement: "bottom", xOffset: "0", arrowOffset: "center",
          url:"../topics", width: 200},
      {target: "search-box-column", placement: "top", xOffset: "0",
       arrowOffset: "center", width: 170},
      {target: "before-limit", placement: "top", xOffset: "0",
       arrowOffset: "center", width: 170},
      {target: "item-create", placement: "bottom", xOffset: "0", arrowOffset: "center",
          url:"../moduleassessments", width: 200},
      {target: "moduleassessments-table-head", placement: "left",
       xOffset: "center", yOffset: "20", arrowOffset: "center", width: 170},
      {target: "search", placement: "top",
       xOffset: "0", arrowOffset: "center", width: 320},
      {target: "modules-table-head", placement: "left", xOffset: "center", arrowOffset: "center",
       yOffset: "20", url:"../emodules", width: 170},
      {target: "courses-table-head", placement: "left", xOffset: "center", arrowOffset: "center",
       yOffset: "20", url:"../courses", width: 170}
  ]
};

/* ========== */
/* TOUR SETUP */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
  }
},

startBtnEl = document.getElementById("startTourBtn");
//console.log(hopscotch.getState());
if (startBtnEl) {

  addClickListener(startBtnEl, function() {
    console.log("startTourBtn");
    if (!hopscotch.isActive) {
      hopscotch.endTour(true);
      hopscotch.startTour(tour, 0);
    }
  });
}
 else {
  var step = parseInt(getQueryString('step'));
  if (!isNaN(step)) {
      switch (step) {
          case 2:
          case 3:
          case 10:
          case 11:
              var calloutMgr = hopscotch.getCalloutManager();
              callOut(calloutMgr, step);
              break;
          case 4:
              var calloutMgr = hopscotch.getCalloutManager();

              for(var i=4; i<7; i++) {
                  callOut(calloutMgr, i);
              }
              break;

          case 7:
              var calloutMgr = hopscotch.getCalloutManager();

              for(var i=7; i<10; i++) {
                  callOut(calloutMgr, i);
              }
              break;

          default:
      }
  }

  // Assuming we're on page 2.
  if (hopscotch.getState() === "hello-hopscotch:1" /*|| (step == '2' || step == 2)*/) {
    // tour id is hello-hopscotch and we're on the second step. sounds right, so start the tour!
    hopscotch.startTour(tour,1);
  } else {
    if (hopscotch.getState() === "hello-hopscotch:2" /*|| (step == '3' || step == 3)*/) {
      // tour id is hello-hopscotch and we're on the third step. sounds right, so start the tour!
      hopscotch.startTour(tour,2);
    }
    if (hopscotch.getState() === "hello-hopscotch:3"  /*|| (step == '4' || step == 4)*/) {
      //create highlights for attachments and topic design buttons
      //$('.item-attach').first().attr('id','topic-attach-demo');
      //$('.item-question').first().attr('id','topic-design-demo');

      // tour id is hello-hopscotch and we're on the fourth step. sounds right, so start the tour!
      hopscotch.startTour(tour,3);
    }
    if (hopscotch.getState() === "hello-hopscotch:6"  /*|| (step == '7' || step == 7)*/) {
      //create highlight for Manage question button
      $('.item-question').first().attr('id','assessment-question-demo');

      hopscotch.startTour(tour,6);
    }
    if (hopscotch.getState() === "hello-hopscotch:7") {
      // tour id is hello-hopscotch and we're on the 8th step. sounds right, so start the tour!
      hopscotch.startTour(tour,7);
    }
    if (hopscotch.getState() === "hello-hopscotch:8") {
      // tour id is hello-hopscotch and we're on the 9th step. sounds right, so start the tour!
      hopscotch.startTour(tour,8);
    }
    if (hopscotch.getState() === "hello-hopscotch:9") {
      //create highlight for Manage module topics button
      //$('.item-managetopics').first().attr('id','module-topic-demo');

      // tour id is hello-hopscotch and we're on the 10th step. sounds right, so start the tour!
      hopscotch.startTour(tour,9);
    }
    if (hopscotch.getState() === "hello-hopscotch:10") {
      //create highlight for Manage course module button
      //$('.item-module').first().attr('id','course-module-demo');

      // tour id is hello-hopscotch and we're on the 11th(last) step. sounds right, so start the tour!
      hopscotch.startTour(tour,10);
    }
  }

}

jQuery('.stepwizard-step button:not(:disabled)').click(function(e) {
  e.preventDefault();
  var idx = parseInt($(this).attr('data-step-index'));
  switch (idx) {
      case 2:
      case 3:
      case 4:
      case 7:
      case 10:
      case 11:
          window.location = callouts.steps[idx - 1].url + "?step=" + idx;
          break;
      default:
  }
});

function callOut(calloutMgr, idx){
    calloutMgr.createCallout({
        id: 'step-' + idx,
        target: callouts.steps[idx-1].target,
        placement: callouts.steps[idx-1].placement,
        title: tour.steps[idx-1].title,
        content: tour.steps[idx-1].content,
        xOffset: callouts.steps[idx-1].xOffset,
        yOffset: callouts.steps[idx-1].yOffset,
        arrowOffset: callouts.steps[idx-1].arrowOffset,
        width: callouts.steps[idx-1].width || 280
    });

}
