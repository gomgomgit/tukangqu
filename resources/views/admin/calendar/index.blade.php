@extends('layouts.app')

@section('link')
	{{-- <link rel="stylesheet" type="text/css" href="{{asset('deskapp/vendors/styles/core.css')}}"> --}}
  {{-- <link rel="stylesheet" type="text/css" href="{{asset('deskapp/vendors/styles/icon-font.min.css')}}"> --}}
	<link rel="stylesheet" type="text/css" href="{{asset('deskapp/src/plugins/fullcalendar/fullcalendar.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('deskapp/vendors/styles/style.css')}}">
@endsection

@section('main-content')
	<div class="card-box mb-30">
    <!-- horizontal Basic Forms Start -->
    <div class="pd-20 card-box mb-30">
      <div class="clearfix">
        <div class="pull-left">
          <h4 class="text-blue h4">Form Tambah User</h4>
        </div>
      </div>

					<div class="calendar-wrap">
						<div id='calendar'></div>
					</div>
					<!-- calendar modal -->
					<div id="modal-view-event-survey" class="modal modal-top fade calendar-modal">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-body">
									<h4 class="h4 border-bottom py-2"><span class="event-icon weight-400 mr-3"><i class="icon-copy dw dw-map-7"></i></span><span class="event-title"></span></h4>
									<div class="event-body py-3">
                    <div class="d-flex">
                      <div>
                        <p><b>Surveyer </b></p>
                        <p><b>No Hp </b></p>
                        <p><b>Jam </b></p>
                      </div>
                      <div>
                        <p><b> &nbsp;&nbsp;:&nbsp; </b></p>
                        <p><b> &nbsp;&nbsp;:&nbsp; </b></p>
                        <p><b> &nbsp;&nbsp;:&nbsp; </b></p>
                      </div>
                      <div>
                        <p class="event-survey-name"></p>
                        <p class="event-survey-number"></p>
                        <p class="event-survey-time"></p>
                      </div>
                    </div>
                  </div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					<div id="modal-view-" class="modal modal-top fade calendar-modal">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-body">
									<h4 class="h4"><span class="event-icon weight-400 mr-3"></span><span class="event-title"></span></h4>
									<div class="event-body"></div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>

					<div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<form id="add-event">
									<div class="modal-body">
										<h4 class="text-blue h4 mb-10">Add Event Detail</h4>
										<div class="form-group">
											<label>Event name</label>
											<input type="text" class="form-control" name="ename">
										</div>
										<div class="form-group">
											<label>Event Date</label>
											<input type='text' class="datetimepicker form-control" name="edate">
										</div>
										<div class="form-group">
											<label>Event Description</label>
											<textarea class="form-control" name="edesc"></textarea>
										</div>
										<div class="form-group">
											<label>Event Color</label>
											<select class="form-control" name="ecolor">
												<option value="fc-bg-default">fc-bg-default</option>
												<option value="fc-bg-blue">fc-bg-blue</option>
												<option value="fc-bg-lightgreen">fc-bg-lightgreen</option>
												<option value="fc-bg-pinkred">fc-bg-pinkred</option>
												<option value="fc-bg-deepskyblue">fc-bg-deepskyblue</option>
											</select>
										</div>
										<div class="form-group">
											<label>Event Icon</label>
											<select class="form-control" name="eicon">
												<option value="circle">circle</option>
												<option value="cog">cog</option>
												<option value="group">group</option>
												<option value="suitcase">suitcase</option>
												<option value="calendar">calendar</option>
											</select>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary" >Save</button>
										<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
									</div>
								</form>
							</div>
						</div>
					</div>
  
      <div class="collapse collapse-box" id="horizontal-basic-form1" >
        <div class="code-box">
          <div class="clearfix">
            <a href="javascript:;" class="btn btn-primary btn-sm code-copy pull-left"  data-clipboard-target="#horizontal-basic"><i class="fa fa-clipboard"></i> Copy Code</a>
            <a href="#horizontal-basic-form1" class="btn btn-primary btn-sm pull-right" rel="content-y"  data-toggle="collapse" role="button"><i class="fa fa-eye-slash"></i> Hide Code</a>
          </div>
        </div>
      </div>
    </div>
    <!-- horizontal Basic Forms End -->
	</div>
@endsection

@section('script')
	{{-- <script src="{{asset('vendors/scripts/layout-settings.js')}}"></script> --}}
	<script src="{{asset('deskapp/src/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
  {{-- <script src="{{asset('deskapp/vendors/scripts/calendar-setting.js')}}"></script> --}}
  <script>
    const data = null;

    const self = this;

    axios.get('{{ url("/api/get-event-calendar")}}')
    .then(function(response) {
      self.data = response.data;
      console.log(response.data)
      self.setCalendar()
    })

    function setCalendar () {

      const self = this;

      'use strict';
      // ------------------------------------------------------- //
      // Calendar
      // ------------------------------------------------------ //
      jQuery(function() {
        // page is ready
        jQuery('#calendar').fullCalendar({
          themeSystem: 'bootstrap4',
          // emphasizes business hours
          businessHours: false,
          defaultView: 'month',
          // event dragging & resizing
          editable: true,
          // header
          header: {
            left: 'title',
            center: 'month,agendaWeek,agendaDay',
            right: 'today prev,next'
          },
          events: self.data,
          // events: [
          // {
          //   title: 'Dentist',
          //   description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
          //   start: '2020-12-29T11:30:00',
          //   end: '2020-12-29T012:30:00',
          //   className: 'fc-bg-blue',
          //   icon : "medkit",
          //   allDay: false
          // }
          // ],
          // displayEventTime: false,
          // eventTimeFormat: { // like '14:30:00'
          //   hour: '2-digit',
          //   minute: '2-digit',
          //   second: '2-digit',
          //   meridiem: false
          // },
          // dayClick: function() {
          //   jQuery('#modal-view-event-add').modal();
          // },
          eventClick: function(event, jsEvent, view) {
            if(event.category == 'survey') {
              jQuery('.event-title').html(event.title);
              jQuery('.event-survey-name').html(event.survey_name);
              jQuery('.event-survey-number').html(event.survey_number);
              jQuery('.event-survey-time').html(event.survey_time);
              jQuery('.eventUrl').attr('href',event.url);
              jQuery('#modal-view-event-survey').modal();
            } else {
              alert('Tidak ada event')
            }

          },
        })
    });

    }
  </script>
@endsection