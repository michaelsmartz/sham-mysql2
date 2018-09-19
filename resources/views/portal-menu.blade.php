<li class="nav-header">Navigation</li>
@if (isset($allowedmodules[App\SystemModule::CONST_DASHBOARD]))
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-bar-chart fa-fw"></i>
            <span>@lang('home.DashboardReports')</span>
        </a>
        <ul class="sub-menu">
            <li class="{{ (Request::is('/') || Request::is('home')  ? 'active' : '') }}"><a href="{{URL::to('/')}}/dashboard">Dashboard</a></li>
            <li><a href="{{URL::to('/')}}/reports">Reports</a></li>
        </ul>
    </li>
@endif

@if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR]))
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-users fa-fw"></i>
            <span>@lang('home.CentralHR')</span>
        </a>
        <ul class="sub-menu">
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_EMPLOYEE_DATABASE]))
                <li class="{{ (Request::is('employees/*') || Request::is('employees') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/employees">Employees</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_ORGANISATION_STRUCTURE]))
                <li class="{{ (Request::is('organisationcharts-auto')|| Request::is('organisationcharts-auto/*') || Request::is('organisationcharts') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/organisationcharts">Organisation Charts</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_LIFECYCLE_MANAGEMENT]))
                <li class="{{ (Request::is('timelines/*') || Request::is('disciplinaryactions/*') || Request::is('rewards/*') || Request::is('timelines') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/lifecyclemanagement">Timeline</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_COMPLIANCE_MANAGEMENT]))
                <li class="{{ (Request::is('policies/*') || Request::is('policies') || Request::is('laws/*') || Request::is('laws') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/laws">Compliance</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_ASSETS_MANAGEMENT]))
                <li class="{{ (Request::is('assetallocations') || Request::is('assets') || Request::is('assetsuppliers') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/assetgroups">Assets Allocation</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_ANNOUNCEMENTS]))
                <li> <a href="{{URL::to('/')}}/announcements">Announcements</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_SURVEYS]))
                <li class="{{ (Request::is('surveys/*') || Request::is('surveys') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/surveys">Surveys</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_TODOLIST_INSTANCES]))
                <li> <a href="{{URL::to('/')}}/tasks">To Do List</a></li>
            @endif
        </ul>
    </li>
@endif

@if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL]))
    <li class="has-sub" >
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-home fa-fw" style="font-size: 125%;"></i>
            <span>@lang('home.SelfServicePortal.label')</span>
        </a>
        <ul class="sub-menu">
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_PORTAL]))
                <li class="{{ (Request::is('my-timesheet') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/selfservice-portal">@lang('home.SelfServicePortal.label')</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_DETAILS]))
                <li> <a href="{{URL::to('/')}}/my-details">Profile</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_TRAVEL_REQUESTS]))
                <li> <a data-menu-href="{{URL::to('/')}}/my-travel-plans" href="{{URL::to('/')}}/my-travels">Travels</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_SUGGESTIONS]))
                <li> <a href="{{URL::to('/')}}/my-suggestions">Suggestions</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_COURSES]))
                <li> <a href="{{URL::to('/')}}/my-courses">E-learning</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_SURVEYS]))
                <li class="{{ (Request::is('my-surveys') || Request::is('my-feedback')  ? 'active' : '') }}"> <a href="{{URL::to('/')}}/my-surveys">Surveys</a></li>
            @endif
            {{--
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_DISCIPLINARY_RECORDS]))
                <li> <a href="{{URL::to('/')}}/my-timeline">Timeline</a></li>
            @endif
            --}}
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_VACANCIES]))
                <li> <a data-menu-href="{{URL::to('/')}}/ssp-jobadverts" href="{{URL::to('/')}}/ssp-vacancies">Vacancies</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_ASSESSMENTS]))
                <li> <a href="{{URL::to('/')}}/my-assessments">My assessments</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_CLAIMS]))
                <li> <a href="{{URL::to('/')}}/my-claims">My claims</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_LEAVES]))
                <li> <a href="{{URL::to('/')}}/myleaves">My leave</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_TIMESHEET]))
                <li> <a href="{{URL::to('/')}}/mytimesheet">My timesheet</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_APPRAISAL]))
                <li> <a href="{{URL::to('/')}}/myappraisal-reviews">My appraisal reviews</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_NEWSLETTER]))
                <li> <a href="{{URL::to('/')}}/newsletter">Newsletter</a></li>
            @endif
        </ul>
    </li>
@endif

@if (isset($allowedmodules[App\SystemModule::CONST_TODO_LIST]))
    <li id="admin-todolist-main-li" class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-check-square-o fa-fw" style="font-size: 125%;"></i>
            <span>Todo List</span></a>
        <ul class="sub-menu">
            @if (isset($allowedmodules[App\SystemModule::CONST_TODO_LIST]))
                <li> <a href="{{URL::to('/')}}/todohelper">Help</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_TODO_LIST][App\SystemSubModule::CONST_EVENTS]))
                <li> <a href="{{URL::to('/')}}/events">Master Tasks</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_TODO_LIST][App\SystemSubModule::CONST_TODO_ITEMS]))
                <li> <a href="{{URL::to('/')}}/tasks">Tasks</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_TODO_LIST][App\SystemSubModule::CONST_TODOLIST_INSTANCES]))
                <li class="{{ (Request::is('eventtaskinstances') || Request::is('departmentaltasks') || Request::is('eventallocation') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/eventtaskinstances">Task Allocation</a></li>
            @endif
        </ul>
    </li>
@endif

@if (isset($allowedmodules[App\SystemModule::CONST_QUALITY_ASSURANCE]))
    <li class="has-sub">
        <a href="{{URL::to('/')}}/qa-helper">
            <b class="caret pull-right"></b>
            <i class="fa fa-certificate fa-fw" style="font-size: 125%;"></i>
            <span>@lang('home.QualityAssurance')</span>
        </a>
        <ul class="sub-menu">
            @if (isset($allowedmodules[App\SystemModule::CONST_QUALITY_ASSURANCE][App\SystemSubModule::CONST_ASSESSMENTS]))
                <li><a href="{{URL::to('/')}}/assessments">Assessments</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_QUALITY_ASSURANCE][App\SystemSubModule::CONST_ASSESSMENT_CATEGORIES]))
                <li><a href="{{URL::to('/')}}/assessmentcategories">Assessment Categories</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_QUALITY_ASSURANCE][App\SystemSubModule::CONST_CATEGORY_QUESTIONS]))
                <li><a href="{{URL::to('/')}}/categoryquestions">Category Questions</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_QUALITY_ASSURANCE][App\SystemSubModule::CONST_EVALUATIONS]))
                <li><a href="{{URL::to('/')}}/evaluations">Evaluations</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_QUALITY_ASSURANCE][App\SystemSubModule::CONST_ASSESS]))
                <li><a href="{{URL::to('/')}}/evaluationassessors">Assess</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_QUALITY_ASSURANCE][App\SystemSubModule::CONST_QA_REPORTS]))
                <li><a href="{{URL::to('/')}}/quality-reports">Reports</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_QUALITY_ASSURANCE][App\SystemSubModule::CONST_QA_INSTANCES]))
                <li><a href="{{URL::to('/')}}/instances">Instances</a></li>
            @endif
        </ul>
    </li>
@endif

@if (isset($allowedmodules[App\SystemModule::CONST_TRAINING]))
    <li id="admin-elearning-main-li" class="has-sub">
        <a href="{{URL::to('/')}}/elearning">
            <b class="caret pull-right"></b>
            <i class="fa fa-mortar-board fa-fw"></i>
            <span>E-learning</span>
        </a>
        <ul class="sub-menu">
            @if (isset($allowedmodules[App\SystemModule::CONST_TRAINING][App\SystemSubModule::CONST_COURSES]))
                <li class="{{ (Request::is('courses/*') || Request::is('courses') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/courses">Courses</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_TRAINING][App\SystemSubModule::CONST_MODULES]))
                <li class="{{ (Request::is('modules/*') || Request::is('modules') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/modules">Modules</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_TRAINING][App\SystemSubModule::CONST_TOPICS]))
                <li class="{{ (Request::is('topics/*') || Request::is('topics') || Request::is('topic/*') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/topics">Topics</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_TRAINING][App\SystemSubModule::CONST_MODULE_ASSESSMENT]))
                <li class="{{ (Request::is('moduleassessments/*') || Request::is('moduleassessments') ? 'active' : '') }}" > <a href="{{URL::to('/')}}/moduleassessments">Module Assessments</a></li>
                @endif
                @if (isset($allowedmodules[App\SystemModule::CONST_TRAINING][App\SystemSubModule::CONST_TRAINING_VENUE_MANAGEMENT]))
                        <!-- <li> <a href="{{URL::to('/')}}/buildings">Training Venue Management</a></li> -->
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_TRAINING][App\SystemSubModule::CONST_TRAINING_SESSION_MANAGEMENT]))
                <li> <a href="{{URL::to('/')}}/trainingsessions">Training Sessions</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_TRAINING][App\SystemSubModule::CONST_TRAINING_REPORTS]))
                <li> <a href="{{URL::to('/')}}/trainingreports">Training Reports</a></li>
            @endif
        </ul>
    </li>
@endif

@if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS]))
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <strong><i class="fa fa-gears fa-fw"></i></strong>
            <span>@lang('home.ConfigurationParameters')</span>
        </a>
        <ul class="sub-menu">
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_EMPLOYEE_DATABASE]))
                <li class="{{ (Request::is('branches/*') || Request::is('branches') ? 'active' : '') }}"><a href="{{URL::to('/')}}/branches">Employees</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_ASSETS_MANAGEMENT]))
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <span>Assets Allocation</span>
                    </a>
                    <ul class="sub-menu">
                        @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_ASSET_CONDITION]))
                            <li><a href="{{URL::to('/assetconditions')}}">Asset Condition</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_LIFECYCLE_MANAGEMENT]))
                <li class="has-sub">
                    <a href="javascript:;">Timeline <b class="caret pull-right"></b><span></span></a>
                    <ul class="sub-menu">
                        @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_DISCIPLINARYDECISIONS]))
                            <li><a href="{{URL::to('/disciplinarydecisions')}}">Disciplinary Decisions</a></li>
                        @endif
                        @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_VIOLATION]))
                            <li><a href="{{URL::to('/violations')}}">Violation</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_COMPLIANCE_MANAGEMENT]))
                <li class="{{ (Request::is('policy_categories/*') || Request::is('policy_categories') ? 'active' : '') }}"> <a href="{{URL::to('/')}}/law_categories">Compliance</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_CENTRAL_HR][App\SystemSubModule::CONST_COMPLIANCE_MANAGEMENT]))
                <li> <a href="{{URL::to('/')}}/assessment_types">E-learning</a></li>
            @endif
            @if (isset($allowedmodules[App\SystemModule::CONST_QUALITY_ASSURANCE][App\SystemSubModule::CONST_EVALUATIONS]))
                <li class="has-sub">
                    <a href="javascript:;">Quality Assurance <b class="caret pull-right"></b><span></span></a>
                    <ul class="sub-menu">
                        @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_CATEGORY_QUESTION_TYPE]))
                            <li><a href="{{URL::to('/categoryquestiontypes')}}">Category Question Type</a></li>
                        @endif
                        @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_PRODUCT_CATEGORIES]))
                            <li><a href="{{URL::to('/productcategorys')}}">Product Categories</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            <li class="has-sub">
                <a href="javascript:;">Others <b class="caret pull-right"></b><span></span></a>
                <ul class="sub-menu">
                    @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_COMPANY]))
                        <li><a href="{{URL::to('/companies')}}">Company</a></li>
                    @endif
                    @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_IMPORT]))
                        <li><a href="{{URL::to('/imports')}}">Import</a></li>
                    @endif
                    @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_LEAVE_TYPES]))
                        <li><a href="{{URL::to('/leavetypes')}}">Leave Type</a></li>
                    @endif
                    @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_LINK_TYPES]))
                        <li><a href="{{URL::to('/linktypes')}}">Link Types</a></li>
                    @endif
                    @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_PUBLIC_HOLIDAYS]))
                        <li><a href="{{URL::to('/publicholidays')}}">Public Holidays</a></li>
                    @endif
                    @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_REPORT_TEMPLATES]))
                        <li><a href="{{URL::to('/reporttemplates')}}">Report Templates</a></li>
                    @endif
                    @if (isset($allowedmodules[App\SystemModule::CONST_CONFIGURATION_PARAMETERS][App\SystemSubModule::CONST_SYSTEM_CONFIGURATION]))
                        <li class="{{ (Request::is('systemsubmodules') || Request::is('shamusers') || Request::is('shampermissions') || Request::is('shamuserprofiles') ? 'active' : '') }}"><a data-menu-href="{{URL::to('/')}}/systemsubmodules {{URL::to('/')}}/shamusers {{URL::to('/')}}/shampermissions {{URL::to('/')}}/shamuserprofiles"
                               href="{{URL::to('/systemmodules')}}">System Configuration</a></li>
                    @endif
                </ul>
            </li>
        </ul>
    </li>
@endif

<!-- begin sidebar minify button -->
<li>
    <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify" title="expand/collapse menu">
        <i class="fa fa-angle-double-left"></i></a>
</li>