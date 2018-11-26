@extends('layouts.members_page')
@section('content')
<div class="container-fluid">
    <div class="row">    
<div id='calendar'></div>
</div>
</div>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>
     <script>
  $(document).ready(function() {

      $.ajax({
			url: '/member/eventlist',
			type: "GET",
			beforeSend: function () {

			},
			success: function (data) {
        $('#calendar').fullCalendar({
          themeSystem: 'bootstrap4',
          eventRender: function(eventObj, $el) {
            $el.popover({
              title: eventObj.title,
              content: eventObj.description,
              trigger: 'hover',
              placement: 'top',
              container: 'body'
            });
          },
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth'
          },
          eventDataTransform: function (json) {
              
              data = {  id: 12,
                        title: json.title,
                        description: json.venue.address?json.venue.address:'',
                        start: json.start_date,
                        url: json.url,
                        end: json.end_date,
                    };
              return data;
            },
          weekNumbers: true,
          eventLimit: true, // allow "more" link when too many events
          events: data.events      
        });				
			},
			error: function (xhr, ajaxOptions, thrownError) { // if error occured
				console.log("Error: " + thrownError);
			},
			complete: function () {},
		}); 



  });

</script>      
@stop
