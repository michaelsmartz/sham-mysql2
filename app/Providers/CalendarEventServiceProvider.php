<?php

namespace App\Providers;

use App\CalendarEvent;
use App\EmployeeLeave;
use App\Interview;
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
        $calendar  = $this->calendar($parameters['type']);

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

    public function calendar($type)
    {
        $events = [];

        switch ($type){
            case EmployeeLeave::class :
                $data   = $this->getCalendarLeaves();
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

                $events[] = Calendar::event(
                    $value->title,
                    false,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date),
                    $value->calendable_id,
                    // Add color
                    [
                        'color' => $value->calendable->AbsenceType->colour->code,
                        'textColor' => '#FFFFFF'
                    ]
                );
            }
        }


        if($type === EmployeeLeave::class){
            $calendar = Calendar::addEvents($events)->setOptions(
                ['firstDay' => 1]
            )->setCallbacks([
                'eventRender' => 'function(event,element) {
                      $(element).on("click",function(){
                            location.hash = "#light-modal";
                            return editForm(event.id, event,"leaves");
                      });             
                  }'
            ]);
        }else{
            $calendar = Calendar::addEvents($events)->setOptions(
                ['firstDay' => 1]
            );
        }


        $calendar->title = $title;

        return $calendar;
    }

    public static function getCalendarLeaves(){
        $calendar_leave = CalendarEvent::where('calendable_type', EmployeeLeave::class)->get();
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
