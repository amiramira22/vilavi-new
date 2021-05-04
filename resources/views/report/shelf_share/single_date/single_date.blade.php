<!--SINGLE DATE SHELF SHARE-->
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
                    @lang('project.SHELF_SHARE_REPORT')
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
                    <table class="table table-bordered table-hover" id="shelf_table">

                        <thead>
                        <tr>
                            <th colspan="2"></th>

                            <?php foreach ($dates as $date) { ?>
                            <th class="text-center" colspan="7"><?php echo format_qmw_date($date_type, $date); ?></th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <?php foreach ($dates as $date) { ?>
                            <th>Shelf</th>
                            <th>%</th>
                            <th>Niveau chapeau</th>
                            <th>Niveau des yeux</th>
                            <th>Niveau des mains</th>
                            <th>Niveau des pieds</th>
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
                            <td class="rank"><b><?php echo $i; ?></b></td>
                            <td><?php echo $brand_name; ?></td>

                            <?php foreach ($dates as $date) { ?>
                            <td class="shelf">
                                <?php
                                if (isset($componentDates[$date])) {
                                    echo $componentDates[$date][0];
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="perc">
                                <?php
                                if (isset($componentDates[$date]) && $sum_shelf_date[$date] != 0) {
                                    echo number_format(($componentDates[$date][0] / $sum_shelf_date[$date]) * 100, 2);
                                } else
                                    echo '-';
                                ?>
                            </td>
                            <td class="chapeau">
                                <?php
                                if (isset($componentDates[$date]) && $sum_chapeau_date[$date] != 0) {
                                    echo number_format(($componentDates[$date][2] / $sum_chapeau_date[$date]) * 100, 2);

                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="yeux">
                                <?php
                                if (isset($componentDates[$date]) && $sum_yeux_date[$date] != 0) {
                                    echo number_format(($componentDates[$date][3] / $sum_yeux_date[$date]) * 100, 2);
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="main">
                                <?php
                                if (isset($componentDates[$date]) && $sum_main_date[$date] != 0) {
                                    echo number_format(($componentDates[$date][4] / $sum_main_date[$date]) * 100, 2);
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="pied">
                                <?php
                                if (isset($componentDates[$date]) && $sum_pied_date[$date] != 0) {
                                    echo number_format(($componentDates[$date][5] / $sum_pied_date[$date]) * 100, 2);
                                } else
                                    echo '-';
                                ?>
                            </td>

                        <?php } // end foreach dates       ?>

                        <?php }// end foreach components       ?>
                        <tr>
                            <td colspan="2">Total</td>
                            <td class="totalshelf" id="sum1"></td>
                            <td class="totalperc" id="sum2"></td>
                            <td class="totalchapeau" id="sum3"></td>
                            <td class="totalyeux" id="sum4"></td>
                            <td class="totalmain" id="sum5"></td>
                            <td class="totalpied" id="sum6"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <br>
                <br>
                <!--<div id="shelf_pie_chart" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>-->
                <div style="height:500px; width:100%;" id="shelf_pie_chart"></div>
                <div style="height:500px; width:100%;" id="Niveau-dex-yeux"></div>


            </div>
        </div>
        <!--end::Section-->
    </div>
</div>
<?php
//print_r($report_data);
//print_r($dates);
?>
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
                        url: '<?= route('report.load_shelf_cluster') ?>',
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
    <?php
    // pie chart
    $data_pie_chart = [];
    $dataFor3dChart = [];
    $XCategories3DChart = array();
    foreach ($components as $brand_name => $componentDates) {
        $series3DChart = [];
        foreach ($dates as $date) {
            if ($sum_shelf_date[$date] != 0)
                $total_avg = number_format(($componentDates[$date][0] / $sum_shelf_date[$date]) * 100, 2, '.', '');
            else $total_avg = 0;

            $row_data['name'] = $brand_name;
            $row_data['y'] = $total_avg + 0;
            $brand_color = App\Entities\Brand::where('name', $brand_name)->first()->color;
            $row_data['color'] = $brand_color;
            $data_pie_chart[] = $row_data;
            $XCategories3DChart[] = strval($brand_name);

            $series3DChart[] = number_format(($componentDates[$date][2] / $sum_chapeau_date[$date]) * 100, 2) + 0;
            $series3DChart[] = number_format(($componentDates[$date][3] / $sum_yeux_date[$date]) * 100, 2) + 0;
            $series3DChart[] = number_format(($componentDates[$date][4] / $sum_main_date[$date]) * 100, 2) + 0;
            $series3DChart[] = number_format(($componentDates[$date][5] / $sum_pied_date[$date]) * 100, 2) + 0;
        }
        $dataFor3dChart[$brand_name] = json_encode($series3DChart);
    }
    $brand_data = json_encode($data_pie_chart);
    $XCategories3DChart = json_encode($XCategories3DChart);
    ?>
    showchart(<?php echo $brand_data ?>);

    function showchart(data) {
        var chart = AmCharts.makeChart("shelf_pie_chart", {
            "type": "pie",
            "theme": "light",
            "dataProvider": data,
            "valueField": "y",
            "titleField": "name",
            "titles": [
                {
                    "text": "Shelf share",
                    "size": 15
                }
            ],
            "outlineAlpha": 0.4,
            "colorField": "color",
            "fontSize": 15,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:15px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "legend": {
                "position": "right",
                "marginRight": 0,
                "autoMargins": true
            },
            "export": {
                "enabled": true
            }
        });
    }
</script>



<script>
    var data_bar_chart = [];
    <?php
    foreach ($dataFor3dChart as $brand_name3D => $componentDates3D) {
    $brand_color3D = App\Entities\Brand::where('name', $brand_name3D)->first()->color;
    ?>

    var obj = {
        name: "<?php echo $brand_name3D?>",
        data: <?php echo $componentDates3D ?>,
        color:"<?php echo $brand_color3D?>",
    };
    data_bar_chart.push(obj);
    <?php }  ?>
console.log('amira')
console.log(data_bar_chart)
    showchartBar(data_bar_chart)
    function showchartBar(data) {
         Highcharts.chart('Niveau-dex-yeux', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    viewDistance: 25,
                    depth: 40
                }
            },

            title: {
                text: 'Niveau Des Yeux'
            },

            xAxis: {
                categories: ['Niveau chapeau', 'Niveau des yeux', 'Niveau des mains', 'Niveau des pieds'],

                labels: {
                    skew3d: true,
                    style: {
                        fontSize: '16px'
                    }
                }
            },

            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: '',
                    skew3d: true
                }
            },

            tooltip: {
                headerFormat: '<b>{point.key}</b><br>',
                pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    depth: 40
                }
            },
            series: data
        })
    }

</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var total = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    total += parseFloat($('td.shelf:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(total);
            });
        }

        tally('td.totalshelf');
    });

</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var totalperc = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    totalperc += parseFloat($('td.perc:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(totalperc.toFixed(2));
            });
        }

        tally('td.totalperc');
    });


</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var totalchapeau = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    totalchapeau += parseFloat($('td.chapeau:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(totalchapeau.toFixed(2));
            });
        }

        tally('td.totalchapeau');
    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var totalyeux = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    totalyeux += parseFloat($('td.yeux:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(totalyeux.toFixed(2));
            });
        }

        tally('td.totalyeux');
    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var totalmain = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    totalmain += parseFloat($('td.main:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(totalmain.toFixed(2));
            });
        }

        tally('td.totalmain');
    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var totalpied = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    totalpied += parseFloat($('td.pied:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(totalpied.toFixed(2));
            });
        }

        tally('td.totalpied');
    });
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

