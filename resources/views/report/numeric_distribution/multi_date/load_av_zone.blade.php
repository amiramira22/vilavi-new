<?php
if (!empty($report_data->toArray())) {
    //echo 'yesssssssssss';
    //print_r($report_data);
    ?>
    <div class="table-responsive">

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th></th>
                    <?php foreach ($dates as $date) { ?>
                        <th colspan="3">
                            <?php
                            echo format_month($date);
                            ?>
                        </th>
                    <?php } ?>
                    <th colspan="3">Average</th>
                </tr>
                <tr>
                    <th>Brand</th>
                    <?php foreach ($dates as $date) { ?>
                        <th>AV</th>
                        <th>OOS</th>
                        <th>HA</th>
                    <?php } ?>
                    <th>AV</th>
                    <th>OOS</th>
                    <th>HA</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $i = 0;
                foreach ($components as $brand_name => $componentDates) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $brand_name; ?></td>
                        <?php foreach ($dates as $date) { ?>
                            <td class="av_row<?php echo $zone_id; ?>"><?php
                                if (isset($componentDates[$date][0])) {
                                    echo str_replace(".00", "", number_format(($componentDates[$date][0]), 2, '.', ' '));
                                } else
                                    echo '-';
                                ?> 
                            </td>


                            <td class="oos_row<?php echo $zone_id; ?>"><?php
                                if (isset($componentDates[$date][1])) {
                                    echo str_replace(".00", "", number_format(($componentDates[$date][1]), 2, '.', ' '));
                                } else
                                    echo '-';
                                ?> 
                            </td>

                            <td class="ha_row<?php echo $zone_id; ?>"><?php
                                if (isset($componentDates[$date][2])) {
                                    echo str_replace(".00", "", number_format(($componentDates[$date][2]), 2, '.', ' '));
                                } else
                                    echo '-';
                                ?> 
                            </td>
                        <?php } // end foreach dates      ?>
                        <td class="total-av_row<?php echo $zone_id; ?>"></td>
                        <td class="total-oos_row<?php echo $zone_id; ?>"></td>
                        <td class="total-ha_row<?php echo $zone_id; ?>"></td>
                    <?php }// end foreach components        ?>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div style="height:350px; width:100%;" id="chartHENKELalone<?php echo $zone_id; ?>"></div>
    <br>
    <br>
    <br>
    <br>
<?php } ?>


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
                    <div class="m-section__content" id="content_cluster<?php echo $cluster_id; ?>_<?php echo $zone_id; ?>">
                        <script type="text/javascript">
                            var channel_ids = JSON.stringify(<?php echo $json_channel_ids; ?>);
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $('#content_cluster<?php echo $cluster_id; ?>_<?php echo $zone_id; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                            jQuery.ajax({
                                type: 'post',
                                url: '<?= route('report.load_av_cluster') ?>',
                                data: {_token: CSRF_TOKEN,
                                    start_date: "<?php echo $start_date; ?>",
                                    end_date: "<?php echo $end_date; ?>",
                                    date_type: "<?php echo $date_type; ?>",
                                    category_id: "<?php echo $category_id; ?>",
                                    cluster_id: "<?php echo $cluster_id; ?>",
                                    zone_id: <?php echo $zone_id; ?>,
                                    channel_id: "-1",
                                    json_channel_ids: channel_ids,
                                    zone_val: "<?php echo $zone_id; ?>",
                                    out_val: "0",
                                },

                                success: function (data) {
                                    $('#content_cluster<?php echo $cluster_id; ?>_<?php echo $zone_id; ?>').html(data);
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
            var sum = 0
            var n = 0
            $(this).find('.av_row<?php echo $zone_id; ?>').each(function () {
                var shelf = $(this).text();
                if (!isNaN(shelf) && shelf.length !== 0) {
                    sum += parseFloat(shelf);
                    n++;
                }
            });

            $('.total-av_row<?php echo $zone_id; ?>', this).html(parseFloat(sum / n).toFixed(2));
        });


        $('tr').each(function () {
            var sum = 0
            var n = 0
            $(this).find('.oos_row<?php echo $zone_id; ?>').each(function () {
                var perc = $(this).text();
                if (!isNaN(perc) && perc.length !== 0) {
                    sum += parseFloat(perc);
                    n++;
                }
            });

            $('.total-oos_row<?php echo $zone_id; ?>', this).html(parseFloat(sum / n).toFixed(2));
        });

        $('tr').each(function () {

            var sum = 0
            var n = 0

            $(this).find('.ha_row<?php echo $zone_id; ?>').each(function () {
                var perc = $(this).text();
                if (!isNaN(perc) && perc.length !== 0) {
                    sum += parseFloat(perc);
                    n++;
                }
            });

            $('.total-ha_row<?php echo $zone_id; ?>', this).html(parseFloat(sum / n).toFixed(2));
        });
    });
</script>

<script>
    var data_oos = [];
    var series = [];
    var categories = [];

<?php foreach ($dates as $r) { ?>
        categories.push('<?php echo $r ?>');
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

    Highcharts.chart('chartHENKELalone<?php echo $zone_id; ?>', {

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