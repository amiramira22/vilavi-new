<!--SINGLE DATE -->
<?php
//print_r($report_data);
//print_r($dates);
//print_r($components);
?>


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                      @lang('project.DISTRIBUTION_NUMERIC_REPORT')
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
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="data_table">
                        <thead>
                            <tr>
                                <th></th>
                                <?php foreach ($channels as $channel) { ?>
                                    <th colspan="3">
                                        <?php
                                        echo $channel;
                                        ?>
                                    </th>
                                <?php } ?>
                                <th colspan="3">Average</th>
                            </tr>

                            <tr>
                                <th>Brand</th>
                                <?php foreach ($channels as $channel) { ?>
                                    <th>AV%</th>
                                    <th>OOS%</th>
                                    <th>HA%</th>
                                <?php } ?>
                                <th>AV%</th>
                                <th>OOS%</th>
                                <th>HA%</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            $i = 0;
                            foreach ($components as $brand_name => $componentChannels) {
                                $i++;
                                ?>
                                <tr>
                                    <td class="brand"><?php echo $brand_name; ?></td>
                                    <?php foreach ($channels as $channel) { ?>
                                        <td class="av_row">
                                            <?php
                                            if (isset($componentChannels[$channel][0])) {
                                                echo str_replace(".00", "", number_format($componentChannels[$channel][0], 2, '.', ' '));
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                        <td class="oos_row">
                                            <?php
                                            if (isset($componentChannels[$channel][1])) {
                                                echo str_replace(".00", "", number_format($componentChannels[$channel][1], 2, '.', ' '));
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                        <td class="ha_row">
                                            <?php
                                            if (isset($componentChannels[$channel][2])) {
                                                echo str_replace(".00", "", number_format($componentChannels[$channel][2], 2, '.', ' '));
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>
                                    <?php } // end foreach channels       ?>

                                    <td class="total-av_row"></td>
                                    <td class="total-oos_row"></td>
                                    <td class="total-ha_row"></td>
                                <?php }// end foreach components       ?>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!--<div id="chartHENKELalone" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>-->
                <div style="height:400px; width:100%;" id="chartHENKELalone"></div>
                <br>
                <br>
                <br>
                <br>
                <div style="height:380px; width:100%;" id="column_chart_brands"></div>
            </div>
        </div>
        <!--end::Section-->
    </div>
</div>

<?php
if (!empty($clusters)) {
    foreach ($clusters as $cluster) {
        $cluster_id = $cluster->id;
        $cluster_name = $cluster->name;
        ?> 
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                            <?php echo $cluster_name; ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content" id="content_cluster<?php echo $cluster_id; ?>-1">
                        <script type="text/javascript">

                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            var zone_ids = JSON.stringify(<?php echo $json_zone_ids; ?>);
                            var channel_ids = JSON.stringify(<?php echo $json_channel_ids; ?>);

                            $('#content_cluster<?php echo $cluster_id; ?>-1').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                            jQuery.ajax({
                                type: 'post',
                                url: '<?= route('admin.report.load_av_cluster_channels') ?>',
                                data: {_token: CSRF_TOKEN,
                                    start_date: "<?php echo $start_date; ?>",
                                    end_date: "<?php echo $end_date; ?>",
                                    date_type: "<?php echo $date_type; ?>",
                                    category_id: "<?php echo $category_id; ?>",
                                    cluster_id: "<?php echo $cluster_id; ?>",
                                    json_zone_ids: zone_ids,
                                    json_channel_ids: channel_ids,
                                    zone_val: "0",
                                    out_val: "0"
                                },

                                success: function (data) {
                                    $('#content_cluster<?php echo $cluster_id; ?>-1').html(data);
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}// end clusters foreach      
?>
<?php
// Channels
foreach ($channel_components as $channel => $componentBrands) {
    ?>
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                        <?php echo $channel; ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin::Section-->
            <div class="m-section">
                <div class="m-section__content" style="height:380px; width:100%;" id="chart_channel<?php echo $channel; ?>">

                </div>
            </div>
        </div>
    </div>
    <script>
        pie_data = [];
        pie_data.push(
                {
                    "name": "oos",
                    "y": <?php echo $componentBrands["HENKEL"][0]; ?>,
                    "color": "#4f9e53",
                    "drilldown": "av"
                });

        pie_data.push(
                {
                    "name": "oos",
                    "y": <?php echo $componentBrands["HENKEL"][1]; ?>,
                    "color": "#fc444a",
                    "drilldown": "oos"
                });

        pie_data.push(
                {
                    "name": "ha",
                    "y": <?php echo $componentBrands["HENKEL"][2]; ?>,
                    "color": "#FBB900",
                    "drilldown": "ha"
                });


        var chart = Highcharts.chart("chart_channel<?php echo $channel; ?>", {

            chart: {
                type: 'pie'
            },
            title: {
                text: 'Main Brand STOCK ISSUES PER ZONE'
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            "series": [
                {
                    "name": "Main Brand STOCK ISSUES",
                    "colorByPoint": true,
                    "data": pie_data
                }
            ],
        });


    </script>
    <?php
}
?>
<script>

    $(document).ready(function () {


        var pie_data = [];
        var series = [];
        var axes = [];
        var data_av = [];
        var data_oos = [];
        var data_ha = [];



        $('tr').each(function () {

            var sum_av = 0;
            var sum_oos = 0;
            var sum_ha = 0;

            var n_av = 0;
            var n_oos = 0;
            var n_ha = 0;

            brand = $(this).find('.brand').text();

            $(this).find('.av_row').each(function () {
                var av = $(this).text();
                if (!isNaN(av) && av.length !== 0) {
                    sum_av += parseFloat(av);
                    n_av++;
                }
            });

            $(this).find('.oos_row').each(function () {
                var oos = $(this).text();
                if (!isNaN(oos) && oos.length !== 0) {
                    sum_oos += parseFloat(oos);
                    n_oos++;
                }
            });

            $(this).find('.ha_row').each(function () {
                var ha = $(this).text();
                if (!isNaN(ha) && ha.length !== 0) {
                    sum_ha += parseFloat(ha);
                    n_ha++;
                }
            });
//set the value of currents rows sum to the total-combat element in the current row
            $('.total-av_row', this).html(parseFloat(sum_av / n_av).toFixed(2));
            $('.total-oos_row', this).html(parseFloat(sum_oos / n_oos).toFixed(2));
            $('.total-ha_row', this).html(parseFloat(sum_ha / n_ha).toFixed(2));

            if (brand == "HENKEL") {
                henkel_av = sum_av;
                henkel_oos = sum_oos;
                henkel_ha = sum_ha;
            }

            if (brand != "") {
                column_av = parseFloat(sum_av / n_av).toFixed(0);
                column_oos = parseFloat(sum_oos / n_oos).toFixed(0);
                column_ha = parseFloat(sum_ha / n_ha).toFixed(0);

                column_av = parseInt(column_av, 10);
                column_oos = parseInt(column_oos, 10);
                column_ha = parseInt(column_ha, 10);

                data_av.push(column_av);
                data_oos.push(column_oos);
                data_ha.push(column_ha);

                axes.push(brand);
            }

        }); // End foreach TR


        pie_data.push(
                {
                    "name": "oos",
                    "y": henkel_oos,
                    "color": "#fc444a",
                    "drilldown": "oos"
                });
        pie_data.push(
                {
                    "name": "av",
                    "y": henkel_av,
                    "color": "#4f9e53",
                    "drilldown": "av"
                });
        pie_data.push(
                {
                    "name": "ha",
                    "y": henkel_ha,
                    "color": "#FBB900",
                    "drilldown": "ha"
                }

        );
        showchart(pie_data);
        show_column_chart(axes, data_av, data_oos, data_ha);

        function showchart(data)
        {
            Highcharts.chart('chartHENKELalone', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Main Brand STOCK ISSUES'
                },
                subtitle: {
                    text: ''
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.y:.1f}%'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                },
                "series": [
                    {
                        "name": "HENKEL STOCK ISSUES",
                        "colorByPoint": true,
                        "data": data
                    }
                ],
            });
        }

        function show_column_chart(axes, data_av, data_oos, data_ha)
        {
            Highcharts.chart('column_chart_brands', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Main Brand STOCK ISSUES COLUMN CHART'
                },
                xAxis: {
                    categories: axes
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'availability %'
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'percent'
                    }
                },
                series: [{
                        name: 'av',
                        data: data_av,
                        color: "#4f9e53",
                        maxPointWidth: 20

                    }, {
                        name: 'oos',
                        data: data_oos,
                        color: "#fc444a",
                        maxPointWidth: 20


                    }, {
                        name: 'ha',
                        data: data_ha,
                        color: "#FBB900",
                        maxPointWidth: 20


                    }]
            });

        }

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
                        title: 'STOCK ISSUES REPORT'
                    },
                    {
                        extend: 'copyHtml5',
                        title: 'STOCK ISSUES REPORT'

                    },
                    {
                        extend: 'excelHtml5',
                        title: 'STOCK ISSUES REPORT',
                        header: true
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'STOCK ISSUES REPORT'

                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'STOCK ISSUES REPORT'

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
