import modal from '#/main/core/_old/modal'
import $ from 'jquery'

import 'moment/min/moment-with-locales'

import 'eonasdan-bootstrap-datetimepicker'
import 'jquery-ui/ui/draggable'
import 'jquery-ui/ui/resizable'
import 'fullcalendar/dist/fullcalendar'

$('#archivesList').DataTable({
  dom: 'Bftp',
  buttons: true,
  'pageLength': 50,
  'language': {
    'lengthMenu': 'Afficher _MENU_ presences par page',
    'zeroRecords': 'Rien trouvé - Désolé',
    'info': 'Affichage de la page _PAGE_ sur _PAGES_',
    'infoEmpty': 'Pas de présence valide',
    'infoFiltered': '(filtered from _MAX_ total records)',
    'search': 'Trier les présences'
  }
})

$('#calendar').fullCalendar({
  header: {
    left: 'prev,today,next',
    center: 'title',
    right: ''
  },
  defaultView: 'agendaWeek',
  lang: 'fr',
  weekends: true,
  editable: false,
  contentHeight: 'auto',
  firstDay: 1,
  defaultTimedEventDuration: window.duration,
  forceEventDuration: true,
  timeFormat: 'H(:mm)',
  columnFormat: 'dddd D/M',
  titleFormat: 'MMMM YYYY',
  minTime: window.minTime,
  maxTime: window.maxTime,
  // slotDuration:'{{duration}}',
  eventLimit: true, // allow "more" link when too many events

  events: window.events,
  eventClick: function (calEvent, jsEvent) {
    jsEvent.preventDefault()
    modal.displayForm(
      calEvent.url,
      function () {},
      function () {}
    )
  }
})