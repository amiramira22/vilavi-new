@extends('layouts.admin.template')
@section('content')


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
        {!! Form::open(['url' => 'admin/visit/extrait_journalier', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">

                <label for="example-text-input" class="col-2 col-form-label">Date</label>
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

                <label class="col-2 col-form-label">   @lang('project.MERCHANDISER')s</label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                    {!! Form::select('fo_id', $users , $fo_id ,['class' => 'form-control m-select2','id'=>'m_select2_1']) !!}
                </div>
            </div>

        </div>

        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <label class="col-2 col-form-label">@lang('project.CHANNEL')s</label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                    {!! Form::select('channel_id', $channels , $channel_id ,['class' => 'form-control m-select2','id'=>'m_select2_2']) !!}
                </div>

                <label class="col-2 col-form-label">@lang('project.RESPONSIBLE')s</label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                    {!! Form::select('resp_id', $responsibles , $resp_id ,['class' => 'form-control m-select2','id'=>'m_select2_3']) !!}
                </div>
            </div>
        </div>


        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <div class="row">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                        <button type="submit"
                                class="btn m-btn--pill m-btn--air btn-outline-danger"> @lang('project.SUBMIT')</button>
                        <button type="reset"
                                class="btn m-btn--pill m-btn--air btn-outline-primary"> @lang('project.CANCEL')</button>
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
                        <?php echo(reverse_format($start_date)) ?>
                        @if($fo_id != -1) | {{ $fo_name  }} @endif
                        @if($channel_id != -1) | {{$channel_name  }} @endif
                        @if($resp_id != -1) |@lang('project.RESPONSIBLE') :  {{ $resp_name  }} @endif

                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">

                    <li class="m-portlet__nav-item"></li>
                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                        m-dropdown-toggle="hover" aria-expanded="true">
                        <a href="#"
                           class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                            Actions
                        </a>
                        <div class="m-dropdown__wrapper" style="z-index: 101;">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"
                                  style="left: auto; right: 36px;"></span>
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
                        <th></th>
                        <th></th>
                        <?php
                        foreach ($products as $prd) {
                            //dd($prd);
                        ?>
                        <th> {{ App\Entities\Product::find($prd)->code }} </th>
                        <?php } ?>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <th>Zone</th>
                        <th>Outlet</th>
                        <?php
                        foreach ($products as $prd) {
                        ?>
                        <td> {{ App\Entities\Product::find($prd)->name }} </td>
                        <?php } ?>
                    </tr>
                    <?php foreach ($components as $outlet_id => $componentPds) { ?>
                    <tr>
                        <td>{{ App\Entities\Outlet::find($outlet_id)->outletZone->name }}</td>
                        <td>  {{ App\Entities\Outlet::find($outlet_id)->name }}</td>
                        <?php
                        foreach ($products as $pd) {
                        if (isset($componentPds[$pd])) {
                            $av = $componentPds[$pd];
                        } else
                            $av = '-';
                        ?>
                        <td><?php
                            if ($av == 1) {
                                echo '-';
                            } else if($av==0) {
                                echo 'OOS';
                            }
                            else echo 'HA';
                            ;
                            ?> </td>


                        <?php } ?>
                    </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <script>
        //    var BootstrapDatepicker = function () {
        //
        //        return {
        //            init: function () {
        //                $("#m_datepicker_1_modal").datepicker({
        //                    format: "yyyy-mm-dd",
        //                    todayHighlight: !0,
        //                    orientation: "bottom left",
        //
        //                })
        //
        //            }
        //        }
        //    }();
        //    jQuery(document).ready(function () {
        //        BootstrapDatepicker.init()
        //    });

        var Select2 = {
            init: function () {
                $("#m_select2_1, #m_select2_2,#m_select2_3").select2({
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
                            title: 'Daily Visit Report'
                        },
                        {
                            extend: 'copyHtml5',
                            title: 'Daily Visit Report'

                        },
                        {
                            extend: 'excelHtml5',
                            title: 'Daily Visit Report',
                            header: true


                        },
                        {
                            extend: 'csvHtml5',
                            title: 'Daily Visit Report'

                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Daily Visit Report'

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
@endsection