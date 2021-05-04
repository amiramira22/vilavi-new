
@extends('layouts.admin.template')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!--<link href="{{ asset('assets/fullcalendar-3.10.0/fullcalendar.css') }}" rel="stylesheet" type="text/css"> 
<script src="{{ asset('assets/fullcalendar-3.10.0/lib/jquery.min.js') }}"></script>
<script src="{{ asset('assets/fullcalendar-3.10.0/lib/moment.min.js') }}"></script>
<script src="{{ asset('assets/fullcalendar-3.10.0/fullcalendar.js') }}"></script>
<script src="{{ asset('assets/fullcalendar-3.10.0/gcal.js') }}"></script>-->

<link href="{{ asset('assets/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css"> 
<script src="{{ asset('assets/fullcalendar/lib/jquery.min.js') }}"></script>
<script src="{{ asset('assets/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ asset('assets/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/fullcalendar/gcal.js') }}"></script>



<style>
    .fc-unthemed .fc-toolbar .fc-button:active, .fc-unthemed .fc-toolbar .fc-button.fc-state-active {
        background: #0968a8;
    }

    .table {
        font-size: 12px;
    }
    td{
        text-align: center;
        width: auto;
    }

    th{

        text-align: center;
        width: auto;
    }

    .fc-unthemed .fc-event .fc-content, .fc-unthemed .fc-event-dot .fc-content {
        padding: 0 !important;
    }
    .col-lg-6, .col-lg-9 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 10px !important;
        padding-left: 10px !important;
    }
    .fc-unthemed .fc-event .fc-content:before, .fc-unthemed .fc-event-dot .fc-content:before {
        display: block;
        content: none;
        position: absolute;
        height: 10px;
        width: 10px;
        border-radius: 50%;
        top: 0.7rem;
        left: 0.75rem;
    }
    /*    .fc-unthemed .fc-event, .fc-unthemed .fc-event-dot {
            background: #f1f2f9;
            border: 1px solid #0968a8;
    
        }*/
</style>
<!--begin::Portlet-->
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-calendar-1 m--font-danger"></i>
                </span>
                <h3 class="m-portlet__head-text m--font-danger">
                    Calendar   
                </h3>
            </div>			
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="{{ route('admin.fo_report.fo_information_input') }}" class="btn btn-outline-primary m-btn m-btn--custom m-btn--icon m-btn--outline-2x m-btn--pill m-btn--air">
                        <span>
                            <i class="fas fa-cart-plus"></i>
                            <span>     @lang('project.Add_Fo_Information')</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="row">	
            <div class="col-lg-6">	
                <div id="calendar"></div>
            </div>

            <div class="col-lg-6" id="load_tab">	
            </div>

        </div>	
    </div>
    <!--end::Portlet-->
</div>




<script type="text/javascript">
var date_last_clicked = null;
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$('#calendar').fullCalendar({

    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay',

    },
    titleFormat: {

    },
    buttonText: {
        prev: "",
        next: "",
        today: 'Today',
        month: 'Month',
        week: 'Week',
        day: 'Day'
    },

    eventSources: [
        {
            events: function (start, end, timezone, callback) {
                $.ajax({
                    url: '<?= route('admin.fo_report.get_events') ?>',
                    dataType: 'json',
                    success: function (msg) {
                        var events = msg.events;
                        callback(events);
                        console.log(msg.events);
                    }
                });
            }
        },
    ],

    dayClick: function (date, jsEvent, view) {
        date_last_clicked = $(this);
        $(this).css('background-color', '#bed7f3');

    },
    eventClick: function (event, jsEvent, view) {
        console.log(moment(event.start).format('YYYY-MM-DD'));
        $('#load_tab').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');

        jQuery.ajax({
            url: '<?= route('admin.fo_report.load_tab') ?>',
            data: {_token: CSRF_TOKEN, date: moment(event.start).format('YYYY-MM-DD')},
            type: "POST",
            success: function (data) {

                $('#load_tab').html(data);
            }
        });
    }


});
$(document).ready(function () {

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    console.log(d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day);

    $('#load_tab').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');

    jQuery.ajax({
        url: '<?= route('admin.fo_report.load_tab') ?>',
        data: {_token: CSRF_TOKEN, date: "<?php echo $default_date ?>"},
        type: "POST",
        success: function (data) {
            $('#load_tab').html(data);
        }
    });


});


</script>



@endsection