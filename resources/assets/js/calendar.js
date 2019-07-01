import { Calendar } from '@fullcalendar/core';
import listPlugin from '@fullcalendar/list';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
      plugins: [ listPlugin ]
    });
    calendar.render();
});