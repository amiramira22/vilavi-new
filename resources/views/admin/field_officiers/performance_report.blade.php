@extends('layouts.admin.template')
@section('content')

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

    $(function () {
        $("#datepicker1").datepicker({dateFormat: 'yy-mm-dd'});
        $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<!--<style>
    .m-portlet .m-portlet__body {
        padding: 1rem 2.2rem;
    }
    .m-form .m-form__actions {
        padding: 15px;
    }

    .table {
        font-size: 10px;
    }
</style>-->
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
    {!! Form::open(['url' => 'admin/fo_report/performance', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}



    <div class="form-group m-form__group row">

        <label class="col-lg-2 col-form-label">@lang('project.DATE_TYPE')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::select('date_type', $date_types , $date_type ,['class' => 'form-control ','id'=>'date_type']) !!}
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
                {!! Form::text('end_date', format_qmw_date($date_type, $end_date), ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker_w2']) !!}
                {!! Form::hidden('end_date_w', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_w2_alt']) !!}


                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-calendar-check-o"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row" id="daily">

        <label for="example-text-input" class="col-lg-2 col-form-label">@lang('project.start_date')</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            <div class="input-group date">
                {!! Form::text('start_date', format_qmw_date($date_type, $start_date), ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker1']) !!}


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
                {!! Form::text('end_date', format_qmw_date($date_type, $end_date), ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker2']) !!}


                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-calendar-check-o"></i>
                    </span>
                </div>
            </div>
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
<!--date_type {{$date_type}}
start_date {{$start_date}}
end_date {{$end_date}}-->
<?php //print_r($report_data) ?>


<?php
//echo $report_data;
//echo$start_date;
//echo$end_date;
if ($start_date && $end_date && $date_type && !empty($report_data->toArray())) {

    $dates = array();
    $components = array();

    foreach ($report_data as $row) {
        $date = ($row['date']);
        if (!in_array($date, $dates)) {
            $dates[] = $date;
        }
        //create an array for every brand and the count at a outlet
        //    0                    1                 2                        3                          4                  5                6              7          8                9                    10                       
        $components[$row['fo_name']][$date] = array($row['visits'], $row['branding'], $row['working_hours'], $row['travel_hours'], $row['entry_time'], $row['exit_time'], $row['Gemo'], $row['UHD'], $row['MG'], $row['fo_id']);
    }// end foreach report_data
//    print_r($report_data->toArray());
//    echo'<br>';
//    echo'<br>';
//    echo'<br>';
//
//    print_r($components);
    ?>
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                        FIELD OFFICIER PERFORMANCE
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                <!--                <ul class="m-portlet__nav">
                
                                    <li class="m-portlet__nav-item"></li>
                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                        <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                            Actions
                                        </a>
                                        <div class="m-dropdown__wrapper" style="z-index: 101;">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 36px;"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__section m-nav__section--first">
                                                                <span class="m-nav__section-text">Export Tools</span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="#" class="m-nav__link" id="export_print">
                                                                    <i class="m-nav__link-icon fas fa-print"></i>
                                                                    <span class="m-nav__link-text">Print</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="#" class="m-nav__link" id="export_copy">
                                                                    <i class="m-nav__link-icon fas fa-copy"></i>
                                                                    <span class="m-nav__link-text">Copy</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="#" class="m-nav__link" id="export_excel">
                                                                    <i class="m-nav__link-icon fas fa-file-excel-o"></i>
                                                                    <span class="m-nav__link-text">Excel</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="#" class="m-nav__link" id="export_csv">
                                                                    <i class="m-nav__link-icon fas fa-file-text-o"></i>
                                                                    <span class="m-nav__link-text">CSV</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="#" class="m-nav__link" id="export_pdf">
                                                                    <i class="m-nav__link-icon fas fa-file-pdf-o"></i>
                                                                    <span class="m-nav__link-text">PDF</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>-->
            </div>

        </div>
        <div class="m-portlet__body">
            <!--begin::Section-->
            <div class="m-section">
                <div class="m-section__content">
                    <div class="table-responsive">
                        <table class="table table-bordered m-table m-table--border" id="">

                            <thead>
                                <tr>
                                    <th></th>
                                    <?php foreach ($dates as $date) { ?>
                                        <th colspan="10">
                                            <?php
                                            if ($date_type == "month") {
                                                echo format_month($date);
                                            } else if ($date_type == "week") {
                                                echo format_week($date);
                                            } else {
                                                echo reverse_format($date);
                                            }
                                            ?>
                                        </th>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <th></th>
                                    <?php foreach ($dates as $date) { ?>   

                                        <th colspan="7">Merchendiser Performance</th>
                                        <th colspan="3">OOS</th>

                                    <?php } ?>
                                </tr>
                                <tr>
                                    <th>Admin</th>
                                    <?php foreach ($dates as $date) { ?>
                                        <th>visits</th>
                                        <th>target</th>
                                        <th>Brandings</th>
                                        <th>Working H</th>
                                        <th>Travelling H</th>
                                        <th>Starting Work</th>
                                        <th>Finishing Work</th>
                                        <th>Gemo</th>
                                        <th>UHD</th>
                                        <th>MG</th>


                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $i = 0;
                                foreach ($components as $admin => $componentDates) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $admin; ?></td>

                                        <?php foreach ($dates as $date) {
                                            ?>
                                            <td class="visits">
                                                <?php
                                                if (isset($componentDates[$date])) {
                                                    echo $componentDates[$date][0];
                                                }
                                                ?>
                                            </td>

                                            <?php if ($date_type == "month") { ?>
                                                <td>
                                                    <?php
                                                    if (isset($componentDates[$date])) {
                                                        echo count_target_monthly_visits($componentDates[$date][9], $date);
                                                    }
                                                    ?>
                                                </td>
                                            <?php } else if ($date_type == "daily") { ?>
                                                <td>
                                                    <?php
                                                    if (isset($componentDates[$date])) {
                                                        $today_letter = date('l', strtotime($date));
                                                        echo App\Entities\Outlet::where('active', '=', '1')
                                                                ->where('visit_day', 'like', '%' . date('l', strtotime('today')) . '%')
                                                                ->where('admin_id', '=', $componentDates[$date][9])
                                                                ->count();
                                                    }
                                                    ?>
                                                </td>
                                            <?php } else if ($date_type == "week") { ?>
                                                <td><?php
                                                    if (isset($componentDates[$date])) {
                                                        $daily_target = 0;
                                                        $start_date_traitement = $date;
                                                        $end_date_of_week = date("Y-m-d", strtotime($date . "+ 6 days"));
                                                        while (strtotime($start_date_traitement) <= strtotime($end_date_of_week)) {

                                                            $today_letter = date('l', strtotime($start_date_traitement));

                                                            $daily_target = $daily_target + App\Entities\Outlet::where('active', '=', '1')
                                                                            ->where('visit_day', 'like', '%' . date('l', strtotime('today')) . '%')
                                                                            ->where('admin_id', '=', $componentDates[$date][9])
                                                                            ->count();

                                                            $start_date_traitement = date('Y-m-d', strtotime($start_date_traitement . '+ 1 days'));
                                                        }

                                                        echo $daily_target;
                                                    }
                                                    ?>
                                                </td>
                                            <?php } ?>
                                            <td class="branding">
                                                <?php
                                                if (isset($componentDates[$date])) {   //$branding = json_decode(
                                                    echo $componentDates[$date][1];
                                                    //echo sizeof($branding) ;
                                                }
                                                ?>

                                            </td>

                                            <td class="Working Hours">
                                                <?php
                                                if (isset($componentDates[$date])) {
                                                    $working_hours = $componentDates[$date][2];
                                                    $working_hours = str_replace(" ", "", $working_hours);
                                                    $total = $working_hours; //nombre de secondes 

                                                    $heure = intval(abs($total / 3600));

                                                    $total = $total - ($heure * 3600);

                                                    $minute = intval(abs($total / 60));

                                                    $total = $total - ($minute * 60);

                                                    $seconde = $total;

                                                    echo $heure . " h: " . $minute . " m: " . $seconde . " s";
                                                }
                                                ?> 
                                            </td>


                                            <td class="Travelling hours"><?php
                                                if (isset($componentDates[$date])) {
                                                    $working_hours = $componentDates[$date][3];
                                                    $working_hours = str_replace(" ", "", $working_hours);
                                                    $total = $working_hours; //nombre de secondes 

                                                    $heure = intval(abs($total / 3600));

                                                    $total = $total - ($heure * 3600);

                                                    $minute = intval(abs($total / 60));

                                                    $total = $total - ($minute * 60);

                                                    $seconde = $total;

                                                    echo $heure . " h: " . $minute . " m: " . $seconde . " s";
                                                }
                                                ?> 
                                            </td>

                                            <td class="Starting Work"><?php
                                                if (isset($componentDates[$date])) {

                                                    $hours3 = floor($componentDates[$date][4] / 3600);
                                                    $mins3 = floor($componentDates[$date][4] / 60 % 60);
                                                    if ($mins3 < 10) {
                                                        $mins3 = '0' . $mins3;
                                                    }

                                                    if ($hours3 >= 9 && $mins3 >= 10 && $date_type == 'daily') {
                                                        ?>
                                                        <font color="#F6DC12"><B><?php echo ($hours3 . ':' . $mins3) . ' ! '; ?></B></font>

                                                        <?php
                                                    } else {
                                                        print_r($hours3 . ':' . $mins3);
                                                    }
                                                } else
                                                    echo '-';
                                                ?>
                                            </td>

                                            <td class="Finishing Work"><?php
                                                if (isset($componentDates[$date])) {

                                                    $hours4 = floor($componentDates[$date][5] / 3600);
                                                    $mins4 = floor($componentDates[$date][5] / 60 % 60);
                                                    if ($mins4 < 10) {
                                                        $mins4 = '0' . $mins4;
                                                    }

                                                    print_r($hours4 . ':' . $mins4);
                                                } else
                                                    echo '-';
                                                ?>
                                            </td>
                                            <td class="Gemo"><?php
                                                if (isset($componentDates[$date])) {

                                                    echo number_format($componentDates[$date][6], 2, '.', ' ');
                                                } else
                                                    echo '-';
                                                ?> 
                                            </td>
                                            <td class="UHD"><?php
                                                if (isset($componentDates[$date])) {

                                                    echo number_format($componentDates[$date][7], 2, '.', ' ');
                                                } else
                                                    echo '-';
                                                ?>
                                            </td>

                                            <td class="MG"><?php
                                                if (isset($componentDates[$date])) {

                                                    echo number_format($componentDates[$date][8], 2, '.', ' ');
                                                } else
                                                    echo '-';
                                                ?>
                                            </td>


                                        <?php } // end foreach dates                  ?>

                                    <?php }// end foreach components                  ?>

                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--end::Section-->
        </div>
    </div>
<?php } ?>
<script>
    $(document).ready(function () {
        var value = $('#date_type').val();
        console.log(value);
        if (value == 'month')
        {
            $("#month").show();
            $("#week").hide();
            $("#daily").hide();
        } else if (value == 'week')
        {
            $("#month").hide();
            $("#week").show();
            $("#daily").hide();
        } else if (value == 'daily') {
            $("#month").hide();
            $("#week").hide();
            $("#daily").show();
        }

        $('#date_type').on('change', function () {

            if (this.value == 'month')
            {
                $("#month").show();
                $("#daily").hide();
                $("#week").hide();

            } else if (this.value == 'week')
            {
                $("#month").hide();
                $("#week").show();
                $("#daily").hide();
            } else
            {
                $("#month").hide();
                $("#daily").show();
                $("#week").hide();

            }
        });
    });
</script>

@endsection