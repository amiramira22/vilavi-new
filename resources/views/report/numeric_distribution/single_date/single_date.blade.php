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
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="data_table">

                        <thead>
                        <tr>
                            <th></th>
                            <?php foreach ($dates as $date) { ?>
                            <th class="date" colspan="3">
                                <?php
                                echo format_qmw_date($date_type, $date);
                                ?>
                            </th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td>Brand</td>
                            <?php foreach ($dates as $date) { ?>
                            <td>AV</td>
                            <td>OOS</td>
                            <td>HA</td>
                            <?php } ?>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        $i = 0;
                        foreach ($components as $brand_name => $componentDates) {
                        $i++;
                        ?>
                        <tr>
                            <td>
                                <span class="brand_row"><?php echo $brand_name; ?></span>
                            </td>
                            <?php foreach ($dates as $date) { ?>
                            <td>
                                <span class="av_row">
                                <?php
                                if (isset($componentDates[$date][0])) {
                                    echo str_replace(".00", "", number_format($componentDates[$date][0], 2, '.', ' '));
                                } else
                                    echo '-';
                                ?>
                                </span>
                            </td>
                            <td>
                                <span class="oos_row">
                                <?php
                                if (isset($componentDates[$date][1])) {
                                    echo str_replace(".00", "", number_format($componentDates[$date][1], 2, '.', ' '));
                                } else
                                    echo '-';
                                ?></span>

                            </td>
                            <td>
                                <span class="ha_row">
                                <?php
                                if (isset($componentDates[$date][2])) {
                                    echo str_replace(".00", "", number_format($componentDates[$date][2], 2, '.', ' '));
                                } else
                                    echo '-';
                                ?>
                                </span>
                            </td>
                            <?php } // end foreach dates   ?>
                            <?php }// end foreach components   ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--<div id="chartHENKELalone" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>-->
                {{--<div style="height:400px; width:100%;" id="chartHENKELalone"></div>--}}
                {{--                <div style="height:380px; width:100%;" id="column_chart_brands"></div>--}}
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="row">

                    <div style="height:380px; width:25%;"></div>
                    <div style="height:380px; width:50%;" id="bar_chart_henkel"></div>
                    <div style="height:380px; width:25%;"></div>

                </div>

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
                    $('#content_cluster<?php echo $cluster_id; ?>-1').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                    jQuery.ajax({
                        type: 'post',
                        url: '<?= route('report.load_av_cluster') ?>',
                        data: {
                            _token: CSRF_TOKEN,
                            start_date: "<?php echo $start_date; ?>",
                            end_date: "<?php echo $end_date; ?>",
                            category_id: "<?php echo $category_id; ?>",
                            zone_id: "-1",
                            channel_id: "-1",
                            date_type: "<?php echo $date_type; ?>",
                            cluster_id: "<?php echo $cluster_id; ?>"
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

<script>

    $(document).ready(function () {
        var pie_data = [];
        var series = [];
        var axes = [];
        var data_av = [];
        var data_oos = [];
        var data_ha = [];
        var date;
        var brand;

        $('tr').each(function () {

            var sum_av = 0;
            var sum_oos = 0;
            var sum_ha = 0;

            var n_av = 0;
            var n_oos = 0;
            var n_ha = 0;

            brand = $(this).find('.brand_row').text();
            date = $(this).find('.date').text();

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

            if (brand == '{{env('brand_name')}}') {
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
                "color": "#282828",
                "drilldown": "ha"
            }
        );

        show_bar_chart(date, data_av, data_oos, data_ha);

        function show_bar_chart(date, data_av, data_oos, data_ha) {
            // Create the chart
            Highcharts.chart('bar_chart_henkel', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Availibility Status'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Availibility Status'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%'
                        }
                    }
                },

                series: [
                    {
                        name: "Pourcentage",
                        //colorByPoint: true,
                        data: [
                            {
                                name: "AV",
                                y: parseFloat(data_av),
                                drilldown: "AV",
                                color:"#4f9e53"
                            },
                            {
                                name: "OOS",
                                y: parseFloat(data_oos) ,
                                drilldown: "OOS",
                                color:"#fc444a"
                            },
                            {
                                name: "HA",
                                y: parseFloat(data_ha),
                                drilldown: "HA",
                                color:"#282828"

                            }
                        ]
                    }
                ],

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
