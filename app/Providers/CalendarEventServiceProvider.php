<?php

namespace App\Providers;

use App\CalendarEvent;
use App\EmployeeLeave;
use App\Interview;
use App\Enums\LeaveStatusType;
use Illuminate\Support\Facades\DB;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Illuminate\Support\ServiceProvider;

class CalendarEventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CalendarEventService', function ($app,$parameters) {
            return $this->generate($parameters);
        });
    }


    public function generate($parameters)
    {
        $calendar  = $this->calendar($parameters);

        if(isset($parameters['view']) && ($parameters['view'] == 'modal')) {
            $view      = view('calendar_events.modal-wrap', compact('calendar'))->renderSections();
            return response()->json([
                'title'   => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer'  => $view['modalFooter']
            ]);
        }elseif(isset($parameters['view']) && ($parameters['view'] == 'data')){
            return $calendar;
        }

        return view('calendar_events.calendar',compact('calendar'));
    }

    public function calendar($parameters)
    {
        $events = [];

        switch ($parameters['type']){
            case EmployeeLeave::class :
                if(isset($parameters['filter']) && !empty($parameters['filter'])){
                    $data   = $this->getCalendarLeavesFilter($parameters['filter']);
                }else{
                    $data   = $this->getCalendarLeaves($parameters['status']);
                }
                $title  = "Leaves Calendar";
                break;
            case Interview::class :
                $data   = $this->getCalendarInterviews();
                $title  = "Interview";
                break;
            default:
                $data   = $this->getCalendarDefault();
                $title  = "Planning";
                break;

        }

        if(count($data) > 0 )
        {
            foreach ($data as $key => $value)
            {

                if(isset($value->picture)){
                    $picture = $value->picture;
                }else{
                    $picture = asset('/img/avatar.png');
                }
                $label = explode(' : ',$value->title);
                $events[] = Calendar::event(
                    '',
                    false,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date),
                    $value->calendable_id,
                    [
                        'label'     => $label[0],
                        'wenk'      => $label[1],
                        'color'     => 'transparent',
                        'textColor' => $value->colour_code,
                        'picture'   => $picture
                    ]
                );
            }
        }


        if($parameters['type'] === EmployeeLeave::class){
            if(($parameters['status'] === LeaveStatusType::status_pending) || (!empty($parameters['filter']['leave_status']) && $parameters['filter']['leave_status'] === LeaveStatusType::status_pending)){
                $calendar = Calendar::addEvents($events)->setOptions([
                    'firstDay' => 1,
                    'weekNumbers' =>  true,
                ])->setCallbacks([
                    'eventRender' => 'function(event,element) {
                      $(element).find(".fc-content").remove();
                      $(element).prepend("<span data-wenk-pos=\'right\' data-wenk=\'"+event.wenk+"\' class=\'avatar-preview\'><img id=\'imagePreview\'  style=\'border: 2px solid "+event.textColor+";width: 27px;height:27px;border-radius: 100%;margin-right:5px;\' src=\'"+event.picture+"\'/><b style=\'font-size:13px\'>"+event.label+"</b></span>");
                      $(element).prepend("<input type=\'checkbox\' style=\'margin-left:5px;margin-right:5px;transform: scale(1.3);\' class=\'pending_box\' name=\'pending_box[]\' id=\'pending_box_"+event.id+"\' value=\'"+event.id+"\'>")           
                  }'
                ]);
            }else{
                $calendar = Calendar::addEvents($events)->setOptions([
                    'firstDay' => 1,
                    'weekNumbers' =>  true,
                ])->setCallbacks([
                    'eventRender' => 'function(event,element) {
                      $(element).on("click",function(){
                             location.hash = "#light-modal";
                            return loadUrl("my-leaves/"+event.id+"/view");
                      });  
                      $(element).find(".fc-content").remove();
                      $(element).prepend("<span data-wenk-pos=\'right\' data-wenk=\'"+event.wenk+"\' class=\'avatar-preview\'><img id=\'imagePreview\'  style=\'border: 2px solid "+event.textColor+";width: 27px;height:27px;border-radius: 100%;margin-right:5px;\' src=\'"+event.picture+"\'/><b style=\'font-size:13px\'>"+event.label+"</b></span>");
                  }'
                ]);
            }

        }else{
            $calendar = Calendar::addEvents($events)->setOptions(
                ['firstDay' => 1]
            );
        }


        $calendar->title = $title;

        return $calendar;
    }

    public static function getCalendarLeaves($status){
        $calendar_leave = DB::table('calendar_events')
            ->select('calendar_events.title','calendar_events.start_date','calendar_events.end_date','calendar_events.calendable_id','employees.picture','colours.code as colour_code')
            ->leftjoin('absence_type_employee','absence_type_employee.id','=','calendar_events.calendable_id')
            ->leftjoin('absence_types','absence_types.id','=','absence_type_employee.absence_type_id')
            ->leftjoin('employees','employees.id','=','absence_type_employee.employee_id')
            ->leftjoin('colours','colours.id','=','absence_types.colour_id')
            ->where('calendar_events.calendable_type', EmployeeLeave::class)
            ->where('absence_type_employee.status',$status)
            ->get();
        return $calendar_leave;

    }

    public static function getCalendarLeavesFilter($filter){
        $calendar_leave = DB::table('calendar_events')
            ->select('calendar_events.title','calendar_events.start_date','calendar_events.end_date','calendar_events.calendable_id','employees.picture','colours.code as colour_code')
            ->leftjoin('absence_type_employee','absence_type_employee.id','=','calendar_events.calendable_id')
            ->leftjoin('absence_types','absence_types.id','=','absence_type_employee.absence_type_id')
            ->leftjoin('employees','employees.id','=','absence_type_employee.employee_id')
            ->leftjoin('colours','colours.id','=','absence_types.colour_id')
            ->where('calendar_events.calendable_type', EmployeeLeave::class)
            ->where('absence_type_employee.status',$filter['leave_status'])
            ->where('employees.id',$filter['employee_id'])
            ->get();
        return $calendar_leave;

    }

    public static function getCalendarInterviews(){
        $calendar_interview = CalendarEvent::where('calendable_type', Interview::class)->get();
        return $calendar_interview;
    }

    public static function getCalendarDefault(){
        $calendar = CalendarEvent::all();
        return $calendar;
    }
}
