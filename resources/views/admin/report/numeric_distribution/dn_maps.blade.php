@extends('layouts.admin.template')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src="{{ asset('assets/excel_jquery/src/jquery.table2excel.js') }}"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/tn/tn-all.js"></script>
<style>

    /*    .width-150px{
            width: 80px;
            display: inline-block;
        }

        .m-form .m-form__group {
            margin-bottom: 5px;
            margin-top: 10px;
            padding-top: 5px;
            padding-bottom: 5px;

        }*/
    .body_form{
        font-weight: 350;
        font-size: 12px;
    }


</style>


<script type="text/javascript">
$(function () {
    $("#datepicker1").datepicker({dateFormat: 'yy-mm-dd'});
    $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
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
    {!! Form::open(['url' => 'admin/report/dn_map', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right body_form','autocomplete'=>'off' ]) !!}

    <div class="form-group m-form__group row">

        <label class="col-md-1 col-form-label">@lang('project.start_date')</label>
        <div class="col-md-3">
            {!! Form::text('start_date', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker1']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.end_date')</label>
        <div class="col-md-3">
            {!! Form::text('end_date', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker2']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.CHANNEL')</label>
        <div class="col-md-3">
            {!! Form::select('channel_id', $channels, $channel_id ,['class' => 'form-control m-select2', 'id'=>'select_channels']) !!}
        </div>
    </div>



    <div class="form-group m-form__group row">

        <label class="col-md-1 col-form-label">@lang('project.CATEGORIE')</label>
        <div class="col-md-3">
            {!! Form::select('category_id', $categories, $category_id ,['class' => 'form-control m-select2', 'id'=>'specific_category']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.PRODUCT')</label>
        <div class="col-md-3">
            {!! Form::select('product_id', $products, $product_id ,['class' => 'form-control m-select2', 'id'=>'specific_product']) !!}
        </div>

    </div>
<!--    <div class="form-group m-form__group row">

        <label class="col-md-1 col-form-label">@lang('project.CATEGORIE')</label>
        <div class="col-md-3">
            {!! Form::select('category_id', $categories, $category_id ,['class' => 'form-control m-select2', 'id'=>'specific_category']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.SUB_CATEGORIE')</label>
        <div class="col-md-3">
            {!! Form::select('sub_category_id', $sub_categories, $sub_category_id ,['class' => 'form-control m-select2', 'id'=>'specific_sub_category']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.CLUSTER')</label>
        <div class="col-md-3">
            {!! Form::select('cluster_id', $clusters, $cluster_id ,['class' => 'form-control m-select2', 'id'=>'specific_cluster']) !!}
        </div>
    </div>


    <div class="form-group m-form__group row">

        <label class="col-md-1 col-form-label">@lang('project.PRODUCT_GROUPS')</label>
        <div class="col-md-3">
            {!! Form::select('product_group_id', $product_groups, $product_group_id ,['class' => 'form-control m-select2', 'id'=>'specific_product_group']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.PRODUCT')</label>
        <div class="col-md-3">
            {!! Form::select('product_id', $products, $product_id ,['class' => 'form-control m-select2', 'id'=>'specific_product']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.AV_TYPE')</label>
        <div class="col-md-3">
            {!! Form::select('av_type', $av_types, $av_type ,['class' => 'form-control ']) !!}


                        <select class="form-control " name="av_type">
                            <option value="1">OOS</option>
                            <option value="2">AV</option>
                            <option value="3">HA</option>
                        </select>
        </div>
    </div>-->

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
<!--{{$start_date}}
{{$end_date}}-->
<?php if ($start_date != "" && $end_date != "") { ?>
    <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="true">
                            Maps One
                        </a>
                    </li>

                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab" aria-selected="false">
                            Maps Two
                        </a>
                    </li>
                </ul>
            </div>
            <div class="m-portlet__head-tools">

                <a class="btn btn-xs m-btn--pill m-btn--air btn-outline-danger"
                   href="<?php
                   echo 'export_map/' . $start_date . '/' . $end_date . '/' . $channel_id . '/' . $category_id . '/' . $sub_category_id . '/' . $product_group_id . '/' . $product_id
                   ?>">
                    <i class="icon-md fas fa-external-link-alt"></i> Export OOS
                </a>

            </div>

        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active show" id="m_tabs_6_1" role="tabpanel">
                    <style>
                        .m-demo .m-demo__preview {
                            background: white;
                            border: 2px solid #ffffff;
                            padding: 0px;
                            padding-top: 10px;
                        }
                    </style>
                    <div class="m-section">
                        <div class="m-section__content">
                            <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">


                                <div class="m-demo__preview m-demo__preview--btn">
                                    <center>
                                        <?php
                                        if ($channel_id == -1) {
                                            foreach ($channels_badge as $ch) {
                                                ?>
                                                <span class="m-badge m-badge--<?php echo $ch->template_color ?>
                                                        m-badge--wide  width-150px"><?php echo $ch->name ?>
                                                </span>
                                                <?php
                                            }
                                        } else {
                                            $channel = App\Entities\Channel::find($channel_id);
                                            $channel_name = $channel->name;
                                            $channel_color = $channel->template_color;
                                            ?>
                                            <span class="m-badge m-badge--<?php echo $channel_color ?>
                                                    m-badge--wide  width-150px"><?php echo $channel_name ?>
                                            </span>
                                        <?php } ?>

                                    </center>
                                </div>
                            </div>

                            <?php
                            echo $map_one['js'];
                            echo $map_one['html'];
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                    <style>
                        #container {
                            height: 700px;
                            /*width: 700px;*/
                            min-width: 310px;
                            max-width: 800px;
                            /*margin: 0 auto;*/
                        }

                    </style>
                    <center>
                        <div id="container" class=""></div>
                    </center>
                </div>

            </div>
        </div>
    </div>

<?php }
?>

<script>

    var Select2 = {
        init: function () {
            $("#select_channels,#specific_category,#specific_sub_category,#specific_cluster,#specific_product_group,#specific_product").select2({
                placeholder: ""
            })
        }
    };
    jQuery(document).ready(function () {
        Select2.init()
    });</script>



<script>
//********************************************************

    $('#specific_category').change(function () {

        var data = $(this).find(':selected').val();
        var id = $(this).attr("id");
        console.log(id);
        console.log(data);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: '<?= route('admin.report.get_data_for_dn_maps_report') ?>',
            data: {_token: CSRF_TOKEN, data: data, type: id},
            success: function (data)
            {
                var res = jQuery.parseJSON(data);
                console.log(res.categories);
                console.log(res.sub_categories);
                console.log(res.clusters);
                console.log(res.product_groups);
                console.log(res.products);
                $("#specific_sub_category > option").remove();
                $.each(res.sub_categories, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_sub_category').append(opt);
                });
                //***********************************************************************************

                $("#specific_cluster > option").remove();
                $.each(res.clusters, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_cluster').append(opt);
                });
                //***********************************************************************************

                $("#specific_product_group > option").remove();
                $.each(res.product_groups, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_product_group').append(opt);
                });
                //***********************************************************************************

                $("#specific_product > option").remove();
                $.each(res.products, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_product').append(opt);
                });
                //***********************************************************************************


            }
        });
    });
    $('#specific_sub_category').change(function () {
        var data = $(this).find(':selected').val();
        var id = $(this).attr("id");
        console.log(id);
        console.log(data);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: '<?= route('admin.report.get_data_for_dn_maps_report') ?>',
            data: {_token: CSRF_TOKEN, data: data, type: id},
            success: function (data)
            {
                var res = jQuery.parseJSON(data);
                console.log(res.categories);
                console.log(res.sub_categories);
                console.log(res.clusters);
                console.log(res.product_groups);
                console.log(res.products);
                $("#specific_cluster > option").remove();
                $.each(res.clusters, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_cluster').append(opt);
                });
                //***********************************************************************************

                $("#specific_product_group > option").remove();
                $.each(res.product_groups, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_product_group').append(opt);
                });
                //***********************************************************************************

                $("#specific_product > option").remove();
                $.each(res.products, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_product').append(opt);
                });
                //***********************************************************************************


            }
        });
    });
    $('#specific_cluster').change(function () {

        var data = $(this).find(':selected').val();
        var id = $(this).attr("id");
        console.log(id);
        console.log(data);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: '<?= route('admin.report.get_data_for_dn_maps_report') ?>',
            data: {_token: CSRF_TOKEN, data: data, type: id},
            success: function (data)
            {
                var res = jQuery.parseJSON(data);
                console.log(res.categories);
                console.log(res.sub_categories);
                console.log(res.clusters);
                console.log(res.product_groups);
                console.log(res.products);
                $("#specific_product_group > option").remove();
                $.each(res.product_groups, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_product_group').append(opt);
                });
                //***********************************************************************************

                $("#specific_product > option").remove();
                $.each(res.products, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_product').append(opt);
                });
                //***********************************************************************************


            }
        });
    });
    $('#specific_product_group').change(function () {

        var data = $(this).find(':selected').val();
        var id = $(this).attr("id");
        console.log(id);
        console.log(data);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: '<?= route('admin.report.get_data_for_dn_maps_report') ?>',
            data: {_token: CSRF_TOKEN, data: data, type: id},
            success: function (data)
            {
                var res = jQuery.parseJSON(data);
                console.log(res.categories);
                console.log(res.sub_categories);
                console.log(res.clusters);
                console.log(res.product_groups);
                console.log(res.products);
                //***********************************************************************************

                $("#specific_product > option").remove();
                $.each(res.products, function (id, out)
                {
                    var opt = $('<option/>');
                    opt.val(id);
                    opt.text(out);
                    $('#specific_product').append(opt);
                });
                //***********************************************************************************


            }
        });
    });
</script>
<?php
if (isset($outlets_for_map_two)) {
    //print_r($outlets_for_map_two->toArray());
}
?>
<script>
// Prepare demo data
// Data is joined to map using value of 'hc-key' property by default.
// See API docs for 'joinBy' for more info on linking data and map.

    var mydata = [];
<?php
if (isset($outlets_for_map_two)) {
    foreach ($outlets_for_map_two as $outlet) {
        ?>

            mydata.push(['<?php echo $outlet->code_highmaps; ?>',<?php echo number_format($outlet->data_av, 2, ".", ","); ?>]);
        <?php
    }
}
?>
    console.log('mapsssssssssssssssss');
//    console.log(mydata);
    var data = mydata;
    console.log(data);
    // Create the chart
    Highcharts.mapChart('container', {
        chart: {
            map: 'countries/tn/tn-all',
            borderWidth: 0.2

        },
        colors: ['rgba(19,64,117,0.05)', 'rgba(19,64,117,0.2)', 'rgba(19,64,117,0.4)',
            'rgba(19,64,117,0.5)', 'rgba(19,64,117,0.6)', 'rgba(19,64,117,0.8)', 'rgba(19,64,117,1)'],
        title: {
            text: 'Numeric Distribution: <?php
if ($av_type == 1)
    echo 'oos';
else if ($av_type == 2)
    echo 'av';
else if ($av_type == 3)
    echo 'ha';
?>'
        },
        subtitle: {
            text: ''
        },
        mapNavigation: {
            enabled: true
        },
        legend: {
            title: {
                text: 'availibility: <?php
if ($av_type == 1)
    echo 'oos';
else if ($av_type == 2)
    echo 'av';
else if ($av_type == 3)
    echo 'ha';
?> % per state',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            },
            align: 'left',
            verticalAlign: 'middle',
            floating: false,
            layout: 'vertical',
            valueDecimals: 0,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255, 255, 255, 0.85)',
            symbolRadius: 0,
            symbolHeight: 14
        },
        colorAxis: {
            dataClasses: [{
                    to: 5
                }, {
                    from: 5,
                    to: 10
                }, {
                    from: 10,
                    to: 15
                }, {
                    from: 15,
                    to: 20
                }, {
                    from: 20,
                    to: 30
                }, {
                    from: 30,
                    to: 50
                }, {
                    from: 50
                }]
        },
        series: [{
                data: data,
                name: 'Random data',
                states: {
                    hover: {
                        color: '<?php
if ($av_type == 1)
    echo '#d8545f';
else if ($av_type == 2)
    echo '#bada55';
else if ($av_type == 3)
    echo '#fcf767';
?>'
                    }
                },
                dataLabels: {
                    enabled: true,
                    color: '#FFFFFF',
                    format: '{point.value}'
                },
                animation: true,
                name: '<?php
if ($av_type == 1)
    echo 'oos';
else if ($av_type == 2)
    echo 'av';
else if ($av_type == 3)
    echo 'ha';
?> %',
                states: {
                    hover: {
                        color: '<?php
if ($av_type == 1)
    echo '#d8545f';
else if ($av_type == 2)
    echo '#bada55';
else if ($av_type == 3)
    echo '#fcf767';
?>'
                    }
                },
                tooltip: {
                    valueSuffix: '%'
                },
                shadow: false
            }],

        responsive: {
            rules: [{
                    condition: {
                        maxWidth: 300
                    },
                    chartOptions: {
                        legend: {
                            align: 'center',
                            verticalAlign: 'middle',
                            layout: 'vertical'
                        },

                    }
                }]
        }
    });

</script>


@endsection