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

                                <?php foreach ($dates as $date) { ?>
                                    <th  colspan="3">
                                        <?php
                                        echo format_qmw_date($date_type, $date);
                                        ?>
                                    </th>
                                <?php } ?>
                                <th colspan="3">Average</th>
                            </tr>

                            <tr>

                                <th>Brand</th>

                                <?php foreach ($dates as $date) { ?>
                                    <th>AV%</th>
                                    <th>OOS%</th>
                                    <th>HA%</th>

                                <?php } ?>
                                <th>AV%</th>
                                <th >OOS%</th>
                                <th>HA%</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            $i = 0;
                            foreach ($components as $brand_name => $componentDates) {

                                $i++;
                                ?>
                                <tr>
                                    <td class="brand"><?php echo $brand_name; ?></td>
                                    <?php foreach ($dates as $date) { ?>
                                        <td class="av_row"><?php
                                            if (isset($componentDates[$date][0])) {
                                                echo str_replace(".00", "", number_format($componentDates[$date][0], 2, '.', ' '));
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>


                                        <td class="oos_row"><?php
                                            if (isset($componentDates[$date][1])) {
                                                echo str_replace(".00", "", number_format($componentDates[$date][1], 2, '.', ' '));
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                        <td class="ha_row"><?php
                                            if (isset($componentDates[$date][2])) {
                                                echo str_replace(".00", "", number_format($componentDates[$date][2], 2, '.', ' '));
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                    <?php } // end foreach dates     ?>

                                    <td class="total-av_row"></td>
                                    <td class="total-oos_row"></td>
                                    <td class="total-ha_row"></td>


                                <?php }// end foreach components     ?>


                            </tr>

                        </tbody>

                    </table>

                    <?php //print_r($date_components); ?>
                    <?php //print_r($components); ?>
                </div>
                <br>
                <br>
                <br>
                <br>
                <!--<div id = "container" style = "width: 550px; height: 400px; margin: 0 auto"></div>-->
                <div style="height:500px; width:100%;" id="container"></div>
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
                                url: '<?= route('admin.report.load_av_cluster') ?>',
                                data: {_token: CSRF_TOKEN,
                                    start_date: "<?php echo $start_date; ?>",
                                    end_date: "<?php echo $end_date; ?>",
                                    date_type: "<?php echo $date_type; ?>",
                                    category_id: "<?php echo $category_id; ?>",
                                    cluster_id: "<?php echo $cluster_id; ?>",
                                    zone_id: "-1",
                                    channel_id: "-1"
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

            $('.total-av_row', this).html(parseFloat(sum_av / n_av).toFixed(2));
            $('.total-oos_row', this).html(parseFloat(sum_oos / n_oos).toFixed(2));
            $('.total-ha_row', this).html(parseFloat(sum_ha / n_ha).toFixed(2));
        }); // End foreach TR

    });
</script>

<?php //print_r($dates); ?>
<script>
    var data_oos = [];
    var series = [];
    var categories = [];

<?php foreach ($dates as $date) { ?>
        categories.push('<?php echo $date ?>');
<?php } ?>

    console.log(categories);
    var series = [];
<?php foreach ($components as $brand_name => $componentDates) { ?>
        var data_oos = [];
    <?php foreach ($dates as $date) {
        ?>
            column_oos =<?php echo $componentDates[$date][1] ?>;
            column_oos = parseFloat(column_oos).toFixed(0);
            column_oos = parseInt(column_oos, 10);
            data_oos.push(column_oos);
    <?php }
    ?>
        series.push(
                {
                    name: '<?php echo str_replace("'", "", $brand_name); ?>',
                    data: data_oos
                });
    <?php
}
?>
    console.log(series);

    Highcharts.chart('container', {

        title: {
            text: 'OOS TREND PER BRAND'
        },

        subtitle: {
            text: 'out of stock trend'
        },
        xAxis: {
            categories: categories
        },
        yAxis: {
            title: {
                text: 'OOS %'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },

            }
        },

        series: series,

        responsive: {
            rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
        }

    });
</script>

