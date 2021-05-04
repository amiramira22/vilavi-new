@extends('layouts.admin.template')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="m-portlet m-portlet--tab">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-search m--font-danger"></i>
                </span>
                <h3 class="m-portlet__head-text m--font-danger" style="text-transform: uppercase">
                    Search
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    {!! Form::open(['url' => 'admin/visit/posData', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">

            <label for="example-text-input" class="col-2 col-form-label">@lang('project.start_date')</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                <div class="input-group date">
                    {!! Form::text('start_date', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'m_datepicker_1_modal']) !!}

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
                    {!! Form::text('end_date', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'m_datepicker_2_modal']) !!}

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
                Channels  {!! Form::select('channel_id', $channels , $channel_id ,['class' => 'form-control m-select2','id'=>'specific_channel']) !!}
            </div>
            <div class="col-lg-2 col-md-9 col-sm-12">
                Zones  {!! Form::select('zone_id', $zones , $zone_id ,['class' => 'form-control m-select2','id'=>'specific_zone']) !!}
            </div>


            <label class="col-2 col-form-label">Outlets</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                {!! Form::select('outlet_id', $outlets , null ,['class' => 'form-control m-select2','id'=>'specific_outlet']) !!}
            </div>
        </div>
    </div>


    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col-10">
                    <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-danger"> @lang('project.SUBMIT')</button>
                    <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary"> @lang('project.CANCEL')</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">

                <h3 class="m-portlet__head-text m--font-danger">
                    <?php //echo (reverse_format($start_date)) . '=>' . (reverse_format($end_date)) ?> 
                    @if($outlet_id != -1) Outlet :  {{ $outlet_name  }} | @endif
                    @if($channel_id != -1)  Channel :  {{$channel_name  }}  |  @endif
                    @if($zone_id != -1)Zone : {{ $zone_name  }} @endif
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">

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
                            <th colspan="3"><?php echo $date; ?></th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th>Brand</th>
                        <th>Product</th>
                        <?php foreach ($dates as $date) { ?>
                            <th>AV % </th>
                            <th>OOS % </th>
                            <th>HA % </th>

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

                            <?php foreach ($dates as $date) {
                                ?>

                                <td>
                                    <?php
                                    if (isset($componentDates[$date])) {
                                        $av = $componentDates[$date][1] / $componentDates[$date][0];
                                    } else {
                                        $av = 'No data';
                                    }
                                    echo number_format($av, 2, ',', ' ');
                                    ?>
                                </td>     
                                <td>
                                    <?php
                                    if (isset($componentDates[$date])) {
                                        $oos = $componentDates[$date][2] / $componentDates[$date][0];
                                    } else {
                                        $oos = 'No data';
                                    }
                                    echo number_format($oos, 2, ',', ' ');
                                    ?>
                                </td>   
                                <td>
                                    <?php
                                    if (isset($componentDates[$date])) {
                                        $ha = $componentDates[$date][3] / $componentDates[$date][0];
                                    } else {
                                        $ha = 'No data';
                                    }
                                    echo number_format($ha, 2, ',', ' ');
                                    ?>
                                </td>

                            <?php } // end foreach dates      ?>
                        <?php }// end foreach components      ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

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
                placeholder: "Select a FO"
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
                url: '<?= route('admin.visit.getOutletByZoneChannel') ?>',
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