<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Enums\EventType;
use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class CalendarEventsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new CalendarEvent();
        $this->baseViewPath = 'calendar_events';
        $this->baseRoute = "calendar_events";
        $this->baseFlash = "Calendar events : ";
    }

    public function render($type = 'default')
    {
        $calendar  = $this->calendar($type);
        $calendar->scripts = str_replace("<script>","",$calendar->script());
        $calendar->scripts = str_replace("</script>","",$calendar->scripts);
        $view      = view($this->baseViewPath .'.index', compact('calendar'))->renderSections();
        return response()->json([
            'title'   => $view['modalTitle'],
            'content' => $view['modalContent'],
            'footer'  => $view['modalFooter']
        ]);
    }

    public function calendar($type)
    {
        $events = [];
        switch ($type){
            case EventType::Leave :
                $data   = $this->getCalendarLeaves();
                $title  = "Leaves Calendar";
                break;
            case EventType::Interview :
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

                $events[] = Calendar::event(
                    $value->title,
                    false,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date),
                    null,
                    // Add color
                    [
                        'color' => '#3097D1',
                        'textColor' => '#FFFFFF'
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events)->setOptions(
            ['firstDay' => 1]
        );
        $calendar->title = $title;

        return $calendar;
    }

    public static function getCalendarLeaves(){
        $calendar_leave = CalendarEvent::where('event_type', EventType::Leave)->get();
        return $calendar_leave;

    }

    public static function getCalendarInterviews(){
        $calendar_interview = CalendarEvent::where('event_type', EventType::Interview)->get();
        return $calendar_interview;
    }

    public static function getCalendarDefault(){
        $calendar = CalendarEvent::all();
        return $calendar;
    }
}
