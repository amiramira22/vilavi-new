@extends('layouts.admin.template')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!--

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
-->

<script src="{{asset('assets/amcharts/amcharts.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/amcharts/pie.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/amcharts/serial.js')}}" type="text/javascript"></script>

<script src="{{ asset('assets/amcharts/plugins/export/export.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/amcharts/plugins/export/export.css')}}" type="text/css" media="all" />
<script src="{{ asset('assets/amcharts/themes/light.js')}}"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


<style>

    .table {
        font-size: 14px;

    }
    .m-form.m-form--fit .m-form__group {
        padding-left: 10px;
        padding-right: 100px;
    }

</style>
<script type="text/javascript">
Date.prototype.getWeek = function () {
    var date = new Date(this.getTime());
    date.setHours(0, 0, 0, 0);
// Thursday in current week decides the year.
    date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
// January 4 is always in week 1.
    var week1 = new Date(date.getFullYear(), 0, 4);
// Adjust to Thursday in week 1 and count number of weeks from date to week1.
    return 1 + Math.round(((date.getTime() - week1.getTime()) / 86400000
            - 3 + (week1.getDay() + 6) % 7) / 7);
}
// Returns the four-digit year corresponding to the ISO week of the date.
Date.prototype.getWeekYear = function () {
    var date = new Date(this.getTime());
    date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
    return date.getFullYear();
}
$(function () {
    $("#datepicker_w1").datepicker({
        showWeek: true,
        firstDay: 1,
        onSelect: function (date) {
            var d = new Date(date);
            var index = d.getDay();
            if (index == 0) {
                d.setDate(d.getDate() - 6);
            } else if (index == 1) {
                d.setDate(d.getDate());
            } else if (index != 1 && index > 0) {
                d.setDate(d.getDate() - (index - 1));
            }
            $(this).val(d.getWeekYear() + '-W' + d.getWeek());
            var curr_date = d.getDate();
            var curr_month = d.getMonth() + 1; //Months are zero based
            var curr_year = d.getFullYear();
            $("#datepicker_w1_alt").val(curr_year + "-" + curr_month + "-" + curr_date);
        }
    });
    $("#datepicker_w2").datepicker({
        showWeek: true,
        firstDay: 1,
        onSelect: function (date) {
            var d = new Date(date);
            var index = d.getDay();
            if (index == 0) {
                d.setDate(d.getDate() - 6);
            } else if (index == 1) {
                d.setDate(d.getDate());
            } else if (index != 1 && index > 0) {
                d.setDate(d.getDate() - (index - 1));
            }
            $(this).val(d.getWeekYear() + '-W' + d.getWeek());
            var curr_date = d.getDate();
            var curr_month = d.getMonth() + 1; //Months are zero based
            var curr_year = d.getFullYear();
            $("#datepicker_w2_alt").val(curr_year + "-" + curr_month + "-" + curr_date);
        }
    });
});
$(function () {
    $("#datepicker_m1").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'MM yy',
        altField: '#datepicker_m1_alt',
        altFormat: 'yy-mm-dd',
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        },
    });
});
$(function () {
    $("#datepicker_m2").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'MM yy',
        altField: '#datepicker_m2_alt',
        altFormat: 'yy-mm-dd',
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        },
    });
});
</script>

<div class="m-portlet m-portlet--tab">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-search m--font-danger"></i>
                </span>
                <h3 class="m-portlet__head-text m--font-danger" style="">
                     @lang('project.SEARCH')
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    {!! Form::open(['url' => 'report/shelf_share', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}



    <div class="form-group m-form__group row">

        <label class="col-lg-2 col-form-label"> @lang('project.DATE_TYPE')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::select('date_type', $date_types , $date_type ,['class' => 'form-control ','id'=>'date_type']) !!}
        </div>

        <label class="col-lg-2 col-form-label">@lang('project.CATEGORIE')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::select('category_id', $categories , $category_id ,['class' => 'form-control m-select2','id'=>'m_select_category']) !!}
        </div>


    </div>

    <div class="form-group m-form__group row" id="month">

        <label for="example-text-input" class="col-lg-2 col-form-label">@lang('project.start_date')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            <div class="input-group date">
                {!! Form::text('start_date', format_qmw_date($date_type, $start_date), ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_m1']) !!}
                {!! Form::hidden('start_date_m', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_m1_alt']) !!}

                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-calendar-check-o"></i>
                    </span>
                </div>
            </div>
        </div>

        <label for="example-text-input" class="col-lg-2 col-form-label">@lang('project.end_date')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            <div class="input-group date">
                {!! Form::text('end_date', format_qmw_date($date_type, $end_date), ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker_m2']) !!}
                {!! Form::hidden('end_date_m', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_m2_alt']) !!}


                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-calendar-check-o"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row" id="week">

        <label for="example-text-input" class="col-lg-2 col-form-label">@lang('project.start_date')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            <div class="input-group date">
                {!! Form::text('start_date', format_qmw_date($date_type, $start_date), ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_w1']) !!}
                {!! Form::hidden('start_date_w', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_w1_alt']) !!}

                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-calendar-check-o"></i>
                    </span>
                </div>
            </div>
        </div>

        <label for="example-text-input" class="col-lg-2 col-form-label">@lang('project.end_date')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            <div class="input-group date">
                {!! Form::text('end_date', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker_w2']) !!}
                {!! Form::hidden('end_date_w', format_qmw_date($date_type, $end_date), ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_w2_alt']) !!}


                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-calendar-check-o"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row" id="quarter">

        <label for="example-text-input" class="col-lg-2 col-form-label">@lang('project.start_date')</label>


        <div class="col-lg-4 col-md-9 col-sm-12">
            <div class="input-group">
                {!! Form::number('year1', date('Y'), ['class' => 'form-control m-input', 'placeholder' => 'Year']) !!}
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-ellipsis-h"></i></span>
                </div>
                {!! Form::select('quarter1', $quarter_dates ,'$quarter1',['class' => 'form-control ']) !!}

            </div>

        </div>



        <label for="example-text-input" class="col-lg-2 col-form-label">@lang('project.end_date')</label>

        <div class="col-lg-4 col-md-9 col-sm-12">
            <div class="input-group">
                {!! Form::number('year2',date('Y'), ['class' => 'form-control m-input', 'placeholder' => 'Year']) !!}
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-ellipsis-h"></i></span>
                </div>
                {!! Form::select('quarter2', $quarter_dates ,'$quarter2',['class' => 'form-control ']) !!}

            </div>

        </div>
    </div>

    <div class="form-group m-form__group row">
        <label class="col-lg-2 col-form-label">@lang('project.ZONE')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::select('selected_zone_ids[]', $zones_of_select ,null,['class' => 'form-control m-select2','id'=>'m_select_zone','multiple']) !!}
        </div>

        <label class="col-lg-2 col-form-label">@lang('project.CHANNEL')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::select('selected_channel_ids[]', $channels_of_select ,null,['class' => 'form-control m-select2','id'=>'m_select_channel','multiple']) !!}

        </div>


    </div>


    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-lg-8"></div>
                <div class="col-lg-4">
                    <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-danger"> @lang('project.SUBMIT')</button>
                    <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary"> @lang('project.CANCEL')</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>

@if($date_type && $start_date && $end_date)

@if ($multi_date && !$multi_zone && !$multi_channel)
@include('report.shelf_share.multi_date.multi_date');

@elseif  ($multi_date && $multi_zone) 
@include('report.shelf_share.multi_date.multi_date_zones');

@elseif  ($multi_date && !$multi_zone && $multi_channel)
@include('report.shelf_share.multi_date.multi_date_channels');

@elseif  (!$multi_date && !$multi_zone && !$multi_channel)
@include('report.shelf_share.single_date.single_date');

@elseif  (!$multi_date && $multi_zone)
@include('report.shelf_share.single_date.single_date_zones');

@elseif  (!$multi_date && $multi_channel)
@include('report.shelf_share.single_date.single_date_channels');

@endif
@endif



<!--    date_type {{$date_type}}
    start_date {{$start_date}}
    end_date {{$end_date}}
    category {{$category_id}}
    multi_date {{$multi_date}}
    multi_zone {{$multi_zone}}
    multi_channel {{$multi_channel}}-->

<?php
//    echo 'zone';
//    print_r($selected_zone_ids);
//    echo 'channel';
//    print_r($selected_channel_ids);
?>
<script>
    var Select2 = {
        init: function () {
            $("#m_select_category,#m_select_channel,#m_select_zone").select2({
                placeholder: "Please Select",
            });
        }
    };
    jQuery(document).ready(function () {
        Select2.init();
    });
</script>

<script>
    $(document).ready(function () {
        var value = $('#date_type').val();
        console.log(value);
        if (value == 'month')
        {
            $("#month").show();
            $("#week").hide();
            $("#quarter").hide();
        } else if (value == 'week')
        {
            $("#month").hide();
            $("#week").show();
            $("#quarter").hide();
        } else if (value == 'quarter') {
            $("#month").hide();
            $("#week").hide();
            $("#quarter").show();
        }

        $('#date_type').on('change', function () {
            console.log(this.value);
            if (this.value == 'month')
            {
                $("#month").show();
                $("#week").hide();
                $("#quarter").hide();
            } else if (this.value == 'week')
            {
                $("#month").hide();
                $("#week").show();
                $("#quarter").hide();
            } else {
                $("#month").hide();
                $("#week").hide();
                $("#quarter").show();
            }
        });
    });
</script>
@endsection