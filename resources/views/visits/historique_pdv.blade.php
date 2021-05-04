@extends('layouts.admin.template')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    $(function () {
        $("#datepicker1").datepicker({dateFormat: 'yy-mm-dd'});
        $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<style>
    .m-form.m-form--fit .m-form__group {
        padding-left: 0px;
        padding-right: 100px;
    }

</style>
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
    {!! Form::open(['url' => 'visit/historique_pdv', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">

            <label for="example-text-input" class="col-2 col-form-label">@lang('project.start_date')</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                <div class="input-group date">
                    {!! Form::text('start_date', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker1']) !!}

                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
            </div>


            <label for="example-text-input" class="col-2 col-form-label">@lang('project.end_date')</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                <div class="input-group date">
                    {!! Form::text('end_date', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker2']) !!}

                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">


            <label class="col-2 col-form-label"></label>
            <div class="col-lg-2 col-md-9 col-sm-12">
                @lang('project.CHANNEL')s  {!! Form::select('channel_id', $channels , $channel_id ,['class' => 'form-control m-select2','id'=>'specific_channel']) !!}
            </div>
            <div class="col-lg-2 col-md-9 col-sm-12">
                @lang('project.ZONE')s  {!! Form::select('zone_id', $zones , $zone_id ,['class' => 'form-control m-select2','id'=>'specific_zone']) !!}
            </div>


            <label class="col-2 col-form-label"></label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                @lang('project.OUTLET')s {!! Form::select('outlet_id', $outlets , null ,['class' => 'form-control m-select2','id'=>'specific_outlet','required']) !!}
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


<?php if ($outlet_id != -1) { ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">

                    <h3 class="m-portlet__head-text m--font-danger">
                        <?php //echo (reverse_format($start_date)) . '=>' . (reverse_format($end_date)) ?> 
                        @if($outlet_id != -1) Outlet :  {{ $outlet_name  }} | @endif
                        @if($channel_id != -1)   @lang('project.CHANNEL') :  {{$channel_name  }}  |  @endif
                        @if($zone_id != -1) @lang('project.ZONE') : {{ $zone_name  }} @endif
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">

                    <li class="m-portlet__nav-item"></li>

                </ul>
            </div>
        </div>




        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <div class="table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="data_table">                
                    <thead>
                        <tr>
                            <th colspan="2"></th>
                            <?php foreach ($dates as $date) { ?>
                                <th><?php echo $date; ?></th>
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th> @lang('project.BRAND')</th>
                            <th> @lang('project.PRODUCT')</th>
                            <?php foreach ($dates as $date) { ?>
                                <th>AV % </th>

                            <?php } ?>
                        </tr>
                        <?php foreach ($components as $product_and_brand_name => $componentDates) { ?>
                            <tr>
                                <td>
                                    <?php
                                    $product_and_brand_name = explode('_', $product_and_brand_name);
                                    echo $product_and_brand_name[0];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $product_and_brand_name[1];
                                    ?>
                                </td>

                                <?php foreach ($dates as $date) { ?>

                                    <?php
                                    if (isset($componentDates[$date])) {
                                        $av = $componentDates[$date];
                                    } else {
                                        $av = 'No data';
                                    }
                                    ?>
                                    <td>
                                        <?php
                                        if ($av == 1) {
                                            echo '-';
                                        } else if ($av == 0) {
                                            echo 'OOS';
                                        } else if ($av == 2)
                                            echo 'HA';
                                        else
                                            echo $av;
                                        ?> 
                                    </td>

                                <?php } // end foreach dates     ?>
                            <?php }// end foreach components    ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
<?php } ?>
<script>
    var BootstrapDatepicker = function () {

        return {
            init: function () {
                $("#m_datepicker_1_modal").datepicker({
                    format: "yyyy-mm-dd",
                    todayHighlight: !0,
                    orientation: "bottom left",

                }), $("#m_datepicker_2_modal").datepicker({
                    format: "yyyy-mm-dd",
                    todayHighlight: !0,
                    orientation: "bottom left",

                })

            }
        }
    }();
    jQuery(document).ready(function () {
        BootstrapDatepicker.init()
    });

    var Select2 = {
        init: function () {
            $("#specific_channel, #specific_zone,#specific_outlet").select2({
                placeholder: ""
            })
        }
    };
    jQuery(document).ready(function () {
        Select2.init()
    });

</script>
<script>

    var DatatablesExtensionButtons = {
        init: function () {
            var t;
            t = $("#data_table").DataTable({
                "paging": false,
                "ordering": false,
                "searching": false,

                buttons: [
                    {
                        extend: 'print',
                        title: 'Pos Data Report'
                    },
                    {
                        extend: 'copyHtml5',
                        title: 'Pos Data Report'

                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Pos Data Report',
                        header: true
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Pos Data Report'

                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Pos Data Report'

                    }
                ],
            }), $("#export_print").on("click", function (e) {
                e.preventDefault(), t.button(0).trigger()
            }), $("#export_copy").on("click", function (e) {
                e.preventDefault(), t.button(1).trigger()
            }), $("#export_excel").on("click", function (e) {
                e.preventDefault(), t.button(2).trigger()
            }), $("#export_csv").on("click", function (e) {
                e.preventDefault(), t.button(3).trigger()
            }), $("#export_pdf").on("click", function (e) {
                e.preventDefault(), t.button(4).trigger()
            })
        }
    };
    jQuery(document).ready(function () {
        DatatablesExtensionButtons.init()
    });
</script>



<script type="text/javascript" language="javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function () {
        $('#specific_zone,#specific_channel').change(function () {
            $("#specific_outlet > option").remove();
            //first of all clear select items
            var zone_id = $('#specific_zone').val();
            var channel_id = $('#specific_channel').val();

            // here we are taking country id of the selected one.
            $.ajax({
                type: "POST",
                url: '<?= route('visit.getOutletByZoneChannel') ?>',
                data: {_token: CSRF_TOKEN, zone_id: zone_id, channel_id: channel_id},
                dataType: 'JSON',
                success: function (data)
                {
                    $.each(data, function (id, out)
                    {
                        var opt = $('<option />');
                        opt.val(id);
                        opt.text(out);
                        $('#specific_outlet').append(opt);
                    });
                }
            });

        });

    });
</script>
@endsection