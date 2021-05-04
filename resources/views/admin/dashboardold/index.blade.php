@extends('layouts.admin.template')
@section('content')

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
{{--<script src="http://www.amcharts.com/lib/3/plugins/export/export.js"></script>--}}
<!--*********************************************************-->
<script src="{{ asset('assets/amcharts/amcharts.js') }}"></script>
<script src="{{ asset('assets/amcharts/serial.js') }}"></script>
<script src="{{ asset('assets/amcharts/themes/light.js') }}"></script>
<!--<script src="{{ asset('assets/amcharts/plugins/export/export.min.js') }}"></script>
<link href="{{ asset('assets/amcharts/plugins/export/export.css') }}" rel="stylesheet" type="text/css"> -->

<script src="http://www.amcharts.com/lib/4/core.js"></script>
<script src="http://www.amcharts.com/lib/4/charts.js"></script>
<script src="http://www.amcharts.com/lib/4/themes/animated.js"></script>
<!--*********************************************************-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>



<meta name="csrf-token" content="{{ csrf_token() }}" />


<style>
    /*    .content_widget {
            padding: 0px 40px !important;
        }*/

    .m-widget24 .m-widget24__item .m-widget24__stats {
        margin-top: 2.9rem;
    }
    /*    .m--font-danger{
            color: #2c3d96 !important;
        }*/
</style>
<!--begin:: dashboard indice-->
<div class="content_widget">
    <div class="m-portlet m-portlet_widget">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">


                <div  class="col-md-12 col-lg-6 col-xl-4">
                    <a href="<?php echo url('dashboard/outlets_details'); ?>" target="_blank">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    <span class="m-portlet__head-icon {{env('iconColor')}}">
                                        <i class="flaticon-home-2"></i>
                                    </span>
                                    <span style="padding-left:10px;"></span>
                                    @lang('DASHBOARD.ACTIVE_OUTLETS') 
                                </h4>
                                <span class="m-widget24__stats {{env('iconColor')}}">
                                    {{ $count_outlet }}
                                </span>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: {{ $count_outlet }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">

                                </span>
                                <span class="m-widget24__number">

                                </span>

                            </div>
                        </div>
                    </a>
                </div>
                <!--end::outlet indice-->

                <div  class="col-md-12 col-lg-6 col-xl-4">
                    <a href="<?php echo url('dashboard/daily_details'); ?>" target="_blank">

                        <?php
                        if ($count_target_daily_visits != 0)
                            $daily = (($count_daily_visits / $count_target_daily_visits) * 100) . '%';
                        else
                            $daily = 0;

                        $daily = number_format(floatval($daily), 2);
                        ?>
                        <?php
                        if ($count_target_monthly_visits != 0)
                            $monthly = (($count_monthly_visits / $count_target_monthly_visits) * 100) . '%';
                        else
                            $monthly = 0;
                        $monthly = number_format(floatval($monthly), 2);
                        ?>
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    <span class="m-portlet__head-icon m--font-info">
                                        <i class="flaticon-business"></i>
                                    </span>
                                    <span style="padding-left:10px;"></span>
                                    @lang('DASHBOARD.DAILY_VISITS_VS_TARGET') 

                                </h4>

                                <span class="m-widget24__stats m--font-info">
                                    {{ $count_daily_visits }}
                                </span>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar  m--bg-info" role="progressbar" style="width: <?php echo intval($daily); ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    ACHIVEMENT
                                </span>
                                <span class="m-widget24__number">
                                    {{ $daily }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <!--end::daily indice-->
                <style>
                    /*                    .m--font-danger {
                                            color: #f4516c !important;
                                        }*/
                </style>
                <div  class="col-md-12 col-lg-6 col-xl-4">
                    <a href="<?php echo url('dashboard/monthly_details'); ?>" target="_blank">

                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    <span class="m-portlet__head-icon m--font-danger">
                                        <i class="flaticon-calendar-3"></i>
                                    </span>
                                    <span style="padding-left:10px;"></span>
                                    @lang('DASHBOARD.MONTHLY_VISITS_VS_TARGET') 
                                </h4>
                                <span class="m-widget24__desc">
                                </span>
                                <span class="m-widget24__stats m--font-danger">
                                    {{ $count_monthly_visits }}
                                </span>

                                <div class="progress m-progress--sm">
                                    <div class="progress-bar  m--bg-danger" role="progressbar" style="width: <?php echo intval($monthly); ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    ACHIVEMENT
                                </span>
                                <span class="m-widget24__number">
                                    {{ $monthly }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <!--end::monthly indice-->

            </div>
        </div>
    </div>
</div>
<!--end:: dashboard indice-->

<!--begin::Portlet-->
<div class="row content_widget">
    <div class="col-md-6" id="oos_peer_channel"> 

    </div>

    <div class="col-md-6" id="oos_peer_category"> 

    </div>
</div>
<!--end::Portlet-->


<!--begin::Portlet-->
<div class="row content_widget">
    <div class="col-md-6" id="top_5_oos"> 

    </div>

    <div class="col-md-6" id="numeric_distribution"> 

    </div>
</div>
<!--end::Portlet-->


<!--begin::Portlet-->
<div class="row content_widget">
    <div class="col-md-12" id="oos_trend"> 

    </div>
</div>
<!--end::Portlet-->




<div class="row content_widget">
    <div class="col-md-6" >
        <!--begin:: Widgets/Support Tickets--> 
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text m--font-danger">
                            <i class="flaticon-map-location m--font-danger"></i>
                            <span style="padding-left:10px;"></span>
                            Daily Visits
                        </h3>
                    </div>
                </div>

            </div>
            <div class="m-portlet__body">
                <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="800" data-mobile-height="800" style="height: 800px; ">
                    <?php
                    echo $maps['js'];
                    echo $maps['html'];
                    ?>
                </div>
            </div>
        </div>
        <!--    end:: Widgets/Support Tickets   -->
    </div>


    <div class="col-md-6">
        <!--begin:: Widgets/Support Tickets--> 
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text m--font-danger">
                            <i class="flaticon-comment m--font-danger"></i>
                            <span style="padding-left:10px;"></span>
                            Daily Feeds
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                            <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                                <i class="fas fa-ellipsis-h {{env('iconColor')}}"></i>
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="800" data-mobile-height="800" style="height: 800px; ">
                    <div class="m-widget3">
                        <style>
                            .m-widget3 .m-widget3__item .m-widget3__header .m-widget3__status {
                                display: inline-block;
                                position: relative;
                                float: right;
                                width: 180px;
                                font-size: 0.9rem;
                                font-weight: 800;
                            }
                            .m-widget3 .m-widget3__item .m-widget3__header .m-widget3__user-img .m-widget3__img {
                                width: 2.2rem;
                                border-radius: 50%;
                            }
                            .m-widget3 .m-widget3__item .m-widget3__header .m-widget3__info .m-widget3__time {
                                font-size: 1rem;
                                font-weight: 300;
                            }
                        </style>
                        <?php foreach ($feeds as $feed) { ?>

                            <div class="m-widget3__item">
                                <div class="m-widget3__header">
                                    <?php
                                    if (($feed->fo_photo) && ($feed->fo_photo) != '' && ($feed->fo_photo) != NULL)
                                        $image = $feed->fo_photo;
                                    else
                                        $image = 'user.png';
                                    ?>
                                    <div class="m-widget3__user-img">							 
                                        <!--<img class="m-widget3__img" src="{{ asset('users/'.$image) }}" alt="">--> 
                                        <img class="m-widget3__img" src="http://bcm.capesolution.tn/uploads/users/{{$image}}" alt="">  


                                    </div>
                                    <div class="m-widget3__info">
                                        <span class="m-widget3__username">
                                            {{$feed->fo_name}} 
                                        </span><br> 
                                        <span class="m-widget3__time">
                                            {{$feed->visit_date}} 

                                        </span>		 
                                    </div>
                                    <span class="m-widget3__status m--font-info">
                                        {{$feed->outlet_name}} 
                                    </span>	
                                </div>
                                <div class="m-widget3__body">
                                    <p class="m-widget3__text"> 
                                        {{$feed->remark}} 
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
        <!--    end:: Widgets/Support Tickets   -->
    </div>
</div>


<script type="text/javascript">

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$('#oos_peer_channel').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');
jQuery.ajax({
    type: 'post',
    data: {_token: CSRF_TOKEN},
    url: '<?= route('admin.dashboard.load_oos_peer_channel') ?>',
    success: function (data) {
        $('#oos_peer_channel').html(data);
    }
});



$('#oos_peer_category').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');
jQuery.ajax({
    type: 'post',
    data: {_token: CSRF_TOKEN},
    url: '<?= route('admin.dashboard.load_oos_peer_category') ?>',
    success: function (data) {
        $('#oos_peer_category').html(data);
    }
});

$('#top_5_oos').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');
jQuery.ajax({
    type: 'post',
    data: {_token: CSRF_TOKEN},
    url: '<?= route('admin.dashboard.load_top_5_oos') ?>',
    success: function (data) {
        $('#top_5_oos').html(data);
    }
});


$('#numeric_distribution').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');
jQuery.ajax({
    type: 'post',
    data: {_token: CSRF_TOKEN},
    url: '<?= route('admin.dashboard.load_numeric_distribution') ?>',
    success: function (data) {
        $('#numeric_distribution').html(data);
    }
});



$('#oos_trend').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');

jQuery.ajax({
    type: 'post',
    data: {_token: CSRF_TOKEN},
    url: '<?= route('admin.dashboard.load_oos_trend') ?>',
    success: function (data) {
        $('#oos_trend').html(data);
    }
});



</script>

@endsection