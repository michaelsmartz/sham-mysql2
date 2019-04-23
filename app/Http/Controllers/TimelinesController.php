<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Timeline;
use App\Reward;
use App\Violation;
use App\Enums\TimelineEventType;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Exception;

class TimelinesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Employee();
        $this->baseViewPath = 'timelines';
        $this->baseFlash = 'Timeline ';
    }

    //functions necessary to handle 'resource' type of route
    public function show(Request $request)
    {

        $id = Route::current()->parameter('timeline');
        $employee = $this->contextObj::with(['jobTitle',
                        'department',
                        'branch',
                        'division',
                        'team',
                        'timelines',
                        'historyDepartments.department',
                        'historyRewards.reward',
                        'historyDisciplinaryActions.disciplinaryAction',
                        'historyJoinTermination',
                        'historyJobTitles.jobTitle',
                        'historyQualification.qualification',
                        'historyTeams.team'
                    ])
                    ->where('employees.id',$id)->get()->first();

        $timelines = self::getTimeline($employee);

        return view($this->baseViewPath .'.index', compact('id','timelines'));
    }

    private static function getTimeline($employee) {

        try{
        $timeCompileResults = [];

        foreach( $employee->timelines as $timeline) {
            $timelineEventType = TimelineEventType::getDescription($timeline->timeline_event_type_id);

            $event_id = trim($timeline->event_id);

            switch ($timelineEventType) {
                case "Department":
                    $historyDepartments =  $employee->historyDepartments->where('id', $event_id);

                    if(count($historyDepartments) > 0)
                    {
                        //dd($historyDepartments);
                        foreach ($historyDepartments as $historyDepartment) {
                            $timeline = new Timeline();
                            $timeline->ShortcutType = 1;
                            $timeline->MainClass = 'info';
                            $timeline->Description = "Joined Department: " . optional($historyDepartment->department)->description;
                            $timeline->EventType = $timelineEventType;
                            $timeline->formattedDate = date("Y-m-d", strtotime($historyDepartment->date_occurred));
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                case "Reward":
                    $historyRewards =  $employee->historyRewards->where('id', $event_id);

                    if(count($historyRewards) > 0)
                    {
                        foreach ($historyRewards as $historyReward) {
                            //dd($timeline);
                            //dump($historyReward);
                            $timeline = new Timeline();
                            $timeline->ShortcutType = 2;
                            $timeline->MainClass = 'success';
                            $timeline->Description = "Reward: " . optional($historyReward->reward)->description;
                            $timeline->EventType = $timelineEventType;
                            $timeline->formattedDate = date("Y-m-d", strtotime($historyReward->date_occurred));
                            $timeline->icon = 'fa fa-certificate';
                            $timeCompileResults[] = $timeline;
                        }
                        //die();
                    }
                    break;
                case "Disciplinary Action":
                    $historyDisciplinaries =  $employee->historyDisciplinaryActions->where('id', $event_id);

                    if (count($historyDisciplinaries) > 0) {
                        foreach ($historyDisciplinaries as $historyDisciplinary) {
                            //dd($historyDisciplinary);
                            $timeline = new Timeline();
                            $timeline->ShortcutType = 3;
                            $timeline->MainClass = 'danger';
                            $violation = Violation::find($historyDisciplinary->disciplinaryAction->violation_id);
                            $timeline->DisciplinaryActionId = $historyDisciplinary->disciplinary_action_id;
                            $timeline->Description = "Discriplinary Action: " . $violation->description;
                            $timeline->EventType = $timelineEventType;
                            //$timelineresultObj->Date = "Date: " . $timeline->EventDate;
                            $timeline->formattedDate = date("Y-m-d", strtotime($historyDisciplinary->date_occurred));
                            $timeCompileResults[] = $timeline;
                            If ($violation->id == 3) {
                                $timeline->icon = 'fa fa-exclamation';
                            } else {
                                $timeline->icon = 'fa fa-ban';
                            }
                        }
                    }
                    break;
                case "Join/Termination Date":
                    $historyJoinTerminations = $employee->historyJoinTermination->where('id', $event_id);

                    if (count($historyJoinTerminations) > 0) {
                        foreach ($historyJoinTerminations as $historyJoinTermination) {
                            $timeline = new Timeline();
                            $timeline->ShortcutType = 4;

                            if ($historyJoinTermination->is_joined == true) {
                                $timeline->Description = "Joined Date";
                                $timeline->EventType = "Joined Date";
                                $timeline->MainClass = 'success';
                                $timeline->formattedDate =  date("Y-m-d", strtotime($employee->date_joined));
                            } else {
                                $timeline->Description = "Termination";
                                $timeline->EventType = "Termination";
                                $timeline->formattedDate = date("Y-m-d", strtotime($historyJoinTermination->date_occurred));
                                $timeline->MainClass = 'warning';
                                $timeline->icon = 'fa fa-sign-out';
                            }
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                case "Job Title":
                    $historyJobTitles = $employee->historyJobTitles->where('id', $event_id);

                    if(count($historyJobTitles) > 0)
                    {
                        foreach ($historyJobTitles as $historyJobTitle) {
                            $timeline = new Timeline();
                            $timeline->ShortcutType = 5;
                            $timeline->MainClass = 'info';
                            $timeline->Description = "Started as: " . $historyJobTitle->jobTitle->description;
                            $timeline->EventType = $timelineEventType;
                            $timeline->formattedDate = date("Y-m-d", strtotime($historyJobTitle->date_occurred));
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                case "Team":
                    $historyTeams =  $employee->historyTeams->where('id', $event_id);

                    if (count($historyTeams) > 0) {
                        foreach ($historyTeams as $historyTeam) {
                            $timeline = new Timeline();
                            $timeline->ShortcutType = 6;
                            $timeline->MainClass = 'info';
                            $timeline->Description = "Team: " . $historyTeam->team->description;
                            $timeline->EventType = $timelineEventType;
                            $timeline->formattedDate = date("Y-m-d", strtotime($historyTeam->date_occurred));
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;
                /*
                case "Qualification":

                    $historyQualifications = $employee->historyQualification->where('id', $event_id)->get();

                    if(count($historyQualifications) > 0)
                    {
                        foreach ($historyQualifications as $historyQualification) {
                            $timeline = new Timeline();
                            $timeline->ShortcutType = 7;
                            $timeline->MainClass = 'success';
                            $timeline->Description = "Obtained: " . $historyQualification->qualification->description;
                            $timeline->formattedDate = date("d-m-Y", strtotime($historyQualification->date_occurred));
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;
                */
                default:
                    break;
            }
        }

        $timeCompileResults = collect($timeCompileResults)->sortBy('formattedDate');

        }catch (Exception $exception) {
            $exception->getMessage();
        }
        return $timeCompileResults;

    }

}