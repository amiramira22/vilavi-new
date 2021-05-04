@extends('layouts.admin.template')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src="{{ asset('assets/excel_jquery/src/jquery.table2excel.js') }}"></script>

<script type="text/javascript">
$(function () {
    $("#datepicker1").datepicker({dateFormat: 'yy-mm-dd'});
    $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
});

</script>
<?php
//hcm
$week = date('Y') . '-W' . date('W');
$week_ch = explode('-W', $week);
$week = getStartAndEndDate($week_ch[1], $week_ch[0]);
?>
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
    {!! Form::open(['url' => 'admin/fo_report/routing_trend', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}

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


        <label class="col-md-1 col-form-label">@lang('project.start_date')</label>
        <div class="col-md-3">
            {!! Form::text('start_date', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker1']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.end_date')</label>
        <div class="col-md-3">
            {!! Form::text('end_date', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker2']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.Day')</label>
        <div class="col-md-3">

            <?php
            $days = array();
            for ($i = 0; $i <= 6; $i++) {
                $days[date('Y-m-d', strtotime($week[0] . ' + ' . $i . ' DAY'))] = date('l', strtotime("+$i day", strtotime("$week[0]")));
            }
            ?>

            {!! Form::select('day', $days , $day ,['class' => 'form-control m-select2', 'id'=>'day']) !!}
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
if ($day && ($report_data->toArray())) {

    $dates = array();
    $components = array();
    $components_date = array();
    foreach ($report_data as $row) {
        $date = ($row['date']);
        if (!in_array($date, $dates)) {
            $dates[] = $date;
        }
        asort($dates);
        //0               1                   2                     3                         4                 5                      6         7           8                  9
        $components[$row['admin']][$date] = array($row['visits'], $row['branding'], $row['working_hours'], $row['travel_hours'], $row['entry_time'], $row['exit_time'], $row['Gemo'], $row['UHD'], $row['MG'], $row['admin_id']);
    }// end foreach report_data
    ?>

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                        ROUTING TREND REPORT
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

                                    <?php foreach ($dates as $date) { ?>
                                        <th class ="text-center" colspan="4"><?php
                                            echo reverse_format($date);
                                            ?></th>
                                    <?php } ?>

                                </tr>
                                <tr>
                                    <th>Admin</th>
                                    <?php foreach ($dates as $date) { ?>
                                        <th>W Hours</th>
                                        <th>T hours</th>
                                        <th>S Work</th>
                                        <th>F Work</th>
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


                                            <td class="Working Hours" nowrap>
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

                                                    echo "$heure h : $minute m";
                                                } else
                                                    echo '-';
                                                ?> 
                                            </td>


                                            <td class="Travelling hours" nowrap><?php
                                                if (isset($componentDates[$date])) {
                                                    $working_hours = $componentDates[$date][3];
                                                    $working_hours = str_replace(" ", "", $working_hours);
                                                    $total = $working_hours; //nombre de secondes 

                                                    $heure = intval(abs($total / 3600));

                                                    $total = $total - ($heure * 3600);

                                                    $minute = intval(abs($total / 60));

                                                    $total = $total - ($minute * 60);

                                                    $seconde = $total;

                                                    echo "$heure h : $minute m";
                                                } else
                                                    echo '-';
                                                ?> 
                                            </td>

                                            <td class="Starting Work" nowrap><?php
                                                if (isset($componentDates[$date])) {

                                                    $hours3 = floor($componentDates[$date][4] / 3600);
                                                    $mins3 = floor($componentDates[$date][4] / 60 % 60);
                                                    if ($mins3 < 10) {
                                                        $mins3 = '0' . $mins3;
                                                    }

                                                    if ($hours3 >= 9 && $mins3 >= 10) {
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

                                            <td class="Finishing Work" nowrap><?php
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


                                        <?php } // end foreach dates              ?>

                                    <?php }// end foreach components               ?>

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
            $("#day").select2({
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
            filename: "BVM_Rouring_Trend" + date //do not include extension
        });
    }
    );
</script>

@endsection