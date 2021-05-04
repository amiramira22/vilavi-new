@extends('layouts.admin.template')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src="{{ asset('assets/excel_jquery/src/jquery.table2excel.js') }}"></script>

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
    {!! Form::open(['url' => 'admin/fo_report/routing_survey', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}

    <style>
        .m-form .m-form__actions {
            padding: 15px;
        }
        .m-form .m-form__group {
            margin-bottom: 10px;
            padding-top: 30px;
            padding-bottom: 30px;

        }

    </style>
    <div class="form-group m-form__group row">


        <label class="col-md-1 col-form-label">@lang('project.start_week')</label>
        <div class="col-md-3">
            {!! Form::text('start_date', format_qmw_date('week', $start_date), ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_w1']) !!}
            {!! Form::hidden('start_date_w', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_w1_alt']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.end_week')</label>
        <div class="col-md-3">
            {!! Form::text('end_date', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker_w2']) !!}
            {!! Form::hidden('end_date_w', format_qmw_date('week', $end_date), ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_w2_alt']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.FOS')</label>
        <div class="col-md-3">
            {!! Form::select('fo_id', $fos , $fo_id ,['class' => 'form-control m-select2','id'=>'specific_fo']) !!}
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



<?php
$w_dates = array();
foreach ($report_data as $row) {
    $w_date = $row['w_date'];
    if (!in_array($w_date, $w_dates)) {
        $w_dates[] = $w_date;
    }
    asort($w_dates);
}// end foreach report_data
?>
<?php if (isset($report_data) && !(empty($report_data->toArray()))) { ?>

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                        ROUTING SURVEY REPORT
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                <button class="btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand" id="button_excel">Export EXCEL</button>
            </div>

        </div>
        <div class="m-portlet__body">
            <!--begin::Section-->
            <div class="m-section">
                <div class="m-section__content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="table2excel">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php for ($i = 0; $i <= 6; $i++) { ?>
                                        <th>
                                            <?php
                                            echo date('l', strtotime("+$i day", strtotime("$start_date")));
                                            ?>
                                        </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody id="">

                                <?php
                                $j = 1;
                                foreach ($w_dates as $w_date) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            echo 'week ' . $j;
                                            $j++;
                                            echo '<br>';
                                            echo reverse_format($w_date);
                                            ?>
                                        </td>
                                        <?php for ($i = 0; $i <= 6; $i++) { ?>
                                            <td>
                                                <?php
                                                $date = date('Y-m-d', strtotime("+$i day", strtotime("$w_date")));
                                                echo '(' . reverse_format($date) . ')';
                                                echo '<br>';
                                                foreach ($report_data as $row) {
                                                    if ($row['date'] == $date) {
                                                        echo $row['outlet_name'];
                                                        echo '<br>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php }
                                        ?>

                                    <?php }// end foreach components                   ?>
                                </tr>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


<?php } ?>
<script>

    var Select2 = {
        init: function () {
            $("#specific_fo").select2({
                placeholder: ""
            })
        }
    };
    jQuery(document).ready(function () {
        Select2.init()
    });

</script>

<script>
    var d = new Date();
    var date = d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
    //var day = d.getDate();
    $("#button_excel").click(function () {

        $("#table2excel").table2excel({

            name: "Worksheet Name",
            filename: "BVM_Rouring_Survey" + date //do not include extension
        });
    }
    );
</script>

@endsection