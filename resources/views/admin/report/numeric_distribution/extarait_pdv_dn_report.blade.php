@extends('layouts.admin.template')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <style>

        .table {
            font-size: 14px;
        }
    </style>
    <style>
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
        });</script>

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
        {!! Form::open(['url' => 'admin/report/extarait_pdv_dn_report', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}


        <div class="form-group m-form__group row">

            <label class="col-lg-2 col-form-label">Date Type</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                {!! Form::select('date_type', $date_types , $date_type ,['class' => 'form-control ','id'=>'date_type']) !!}
            </div>

            <label class="col-lg-2 col-form-label">@lang('project.CHANNEL')</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                {!! Form::select('channel_id', $channels ,$channel_id,['class' => 'form-control m-select2','id'=>'m_select_channel',]) !!}
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


        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <div class="row">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                        {!! Form::submit('Submit', ['class' => 'btn m-btn--pill m-btn--air btn-outline-danger']) !!}
                        <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <!--date_type {{$date_type}}
            start_date {{$start_date}}
            end_date {{$end_date}}
            channel {{$channel_id}}-->

    <?php
    //die($categories);
    if ($start_date && $end_date && !empty($categories->toArray())) {
    //dd($categories->count());
    foreach ($categories as $category) {
    //$nb_cat++;
    //if ($category->id != -1) {
    //            $category_id = $category->id;
    //            $category_name = $category->name;
    ?>
    <div class="content_data" id="content_data_<?php echo $category->id; ?>">
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                            <?php echo $category->name; ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="m-section">


                    <!--START DYNAMIC DATA-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th></th>
                                <?php foreach ($product_ids as $product_id) {?>
                                <th class="text-center">
                                    {{App\Entities\Product::find($product_id)->name}}
                                </th>
                                <?php } ?>
                            </tr>
                            <tr>
                                <th>Outlet</th>
                                <?php foreach ($product_ids as $product_id) { ?>
                                <th class="text-center"> AV%</th>
                                <?php } ?>
                            </tr>
                            <thead>
                            <tbody>

                            <?php
                            $i = 0;
                            $sum_products = array();

                            foreach ($components as $outlet_id => $componentPds) {
                            $i++;
                            ?>
                            <tr>
                                <td>{{ App\Entities\Outlet::find($outlet_id)->name  }}</td>
                                <?php foreach ($product_ids as $product_id) { ?>
                                <td clas="col-md-1">
                                    <?php
                                    if (isset($componentPds[$product_id])) {
                                        if (($componentPds[$product_id][1] != 0) && ($componentPds[$product_id][0] == 0) && ($componentPds[$product_id][3] == 0)) {
                                            echo '<p style="color:blue">HA</p>';
                                        } else {
                                            //echo number_format($componentOutlets[$outlet_name][0], 2, '.', ' ');
                                            $perc = number_format(($componentPds[$product_id][3] / ($componentPds[$product_id][0] + $componentPds[$product_id][3])) * 100, 2, '.', ' ');
                                            if (isset($sum_products[$product_id])) {
                                                $sum_products[$product_id] = $sum_products[$product_id] + $perc;
                                            } else {
                                                $sum_products[$product_id] = $perc;
                                            }

                                            if ($perc == '0.00') {
                                                echo '<p style="color:red">';
                                            } else {
                                                echo '<p style="color:black">';
                                            }
                                            echo $perc . '</p>';
                                        }
                                    } else
                                        echo '-';
                                    ?>

                                </td>

                                <?php } // end foreach outlet_names   ?>
                                <?php }// end foreach components   ?>
                            </tr>
                            <tr>
                                <td><b>Overage</b></td>
                                <?php foreach ($product_ids as $product_id) { ?>

                                <td clas="col-md-1">
                                    <?php
                                    if ($i != 0 && (isset($sum_products[$product_id]))) {
                                        echo number_format($sum_products[$product_id] / $i, 2, '.', ' ');
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <?php } // end foreach $product_id   ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!--END DYNAMIC DATA-->
                </div>
            </div>
        </div>
    </div>


    <div class="load-more" lastID="<?php echo $categories->first()->id; ?>" style="display: none;">
        <div class="col-md-12" align="center">
            <img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center"/>
        </div>
    </div>
    <?php
    //} if categ != -1
    }
    ?>

    <input type="hidden" id="row" value="0">
    <input type="hidden" id="all" value="<?php echo $allcount; ?>">

    <script>
        $(document).ready(function () {
            $(window).scroll(function () {
                var position = $(window).scrollTop();
                var bottom = $(document).height() - $(window).height();
                position = parseInt(position);

                if ((position == bottom) || ((position + 1) == bottom)) {

                    var row = Number($('#row').val());
                    var allcount = Number($('#all').val());
                    var rowperpage = 1;
                    row = row + rowperpage;
                    if (row <= allcount) {
                        //$(".content_data").html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');

                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $('#row').val(row);
                        $.ajax({
                            type: 'post',
                            url: '<?= route('admin.report.load_extarait_pdv_dn_per_category') ?>',
                            data: {
                                _token: CSRF_TOKEN,
                                start_date: "<?php echo $start_date; ?>",
                                end_date: "<?php echo $end_date; ?>",
                                channel_id: "<?php echo $channel_id; ?>",
                                date_type: "<?php echo $date_type; ?>",
                                row: row
                            },

                            beforeSend: function () {
                                $('.load-more').show();
                            },
                            success: function (response) {
                                $('.load-more').remove();
                                $(".content_data:last").after(response).show().fadeIn("slow");

                            }


                        });
                    }
                }

            });

        });

    </script>




    <?php } ?>
    <script>
        var Select2 = {
            init: function () {
                $("#m_select_channel").select2({});
            }
        };
        jQuery(document).ready(function () {
            Select2.init();
        });</script>

    <script>
        $(document).ready(function () {
            var value = $('#date_type').val();
            console.log(value);
            if (value == 'month') {
                $("#month").show();
                $("#week").hide();
            } else if (value == 'week') {
                $("#month").hide();
                $("#week").show();
            }

            $('#date_type').on('change', function () {
                console.log(this.value);
                if (this.value == 'month') {
                    $("#month").show();
                    $("#week").hide();
                } else if (this.value == 'week') {
                    $("#month").hide();
                    $("#week").show();
                }
            });
        });


    </script>

@endsection