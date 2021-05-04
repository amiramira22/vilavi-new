<?php
if (!empty($report_data->toArray())) {
    //echo 'yesssssssssss';
    //print_r($report_data);
    ?>
    <div class="table-responsive">

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class ="text-center" colspan="2"></th>

                    <?php foreach ($dates as $date) { ?>
                        <th class ="text-center" colspan="2"><?php
                            echo format_qmw_date($date_type, $date);
                            ;
                            ?>
                        </th>
                    <?php } ?>

                    <th class ="text-center" colspan="2">Average</th>
                </tr>

                <tr>
                    <th>Rank</th>
                    <th>Brand</th>

                    <?php foreach ($dates as $date) { ?>
                        <th>Shelf</th>                        
                        <th>%</th>
                    <?php } ?>

                    <th>Shelf%</th>
                    <th>%</th>
                </tr>



            <thead>

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
                            <td class="shelf_row<?php echo $channel_id; ?>">
                                <?php
                                if (isset($componentDates[$date])) {
                                    echo $componentDates[$date][0];
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="perc_row<?php echo $channel_id; ?>">
                                <?php
                                if (isset($componentDates[$date])) {
                                    echo number_format(($componentDates[$date][0] / $sum_shelf_date[$date]) * 100, 2);
                                } else
                                    echo '-';
                                ?> 
                            </td>
                        <?php } // end foreach dates      ?>

                        <td class="total-shelf_row<?php echo $channel_id; ?>"></td>
                        <td class="total-perc_row<?php echo $channel_id; ?>"></td>                
                    <?php }// end foreach components                  ?>


                </tr>

            </tbody>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br>

    <div style="height:400px; width:100%;" id="trend_channel<?php echo $channel_id; ?>"></div>

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
                    <div class="m-section__content" id="content_cluster<?php echo $cluster_id; ?>_<?php echo $channel_id; ?>">
                        <script type="text/javascript">

                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $('#content_cluster<?php echo $cluster_id; ?>_<?php echo $channel_id; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                            jQuery.ajax({
                                type: 'post',
                                url: '<?= route('report.load_shelf_cluster') ?>',
                                data: {_token: CSRF_TOKEN,
                                    start_date: "<?php echo $start_date; ?>",
                                    end_date: "<?php echo $end_date; ?>",
                                    date_type: "<?php echo $date_type; ?>",
                                    category_id: "<?php echo $category_id; ?>",
                                    cluster_id: "<?php echo $cluster_id; ?>",
                                    channel_id: <?php echo $channel_id; ?>,
                                    zone_id: "-1",
                                    channel_val: "<?php echo $channel_id; ?>",
                                    out_val: "0"
                                },

                                success: function (data) {
                                    $('#content_cluster<?php echo $cluster_id; ?>_<?php echo $channel_id; ?>').html(data);

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
        //iterate through each row in the table

        $('tr').each(function () {


            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum_shelf = 0;
            var sum_shelf_perc = 0;
            var n_shelf = 0;
            var n_shelf_perc = 0;
            brand = $(this).find('.brand').text();
            //find the combat elements in the current row and sum it 
            $(this).find('.shelf_row<?php echo $channel_id; ?>').each(function () {
                var shelf = $(this).text();
                if (!isNaN(shelf) && shelf.length !== 0) {
                    sum_shelf += parseFloat(shelf);
                    n_shelf++;
                }
            });
            $(this).find('.perc_row<?php echo $channel_id; ?>').each(function () {
                var shelf_perc = $(this).text();
                if (!isNaN(shelf_perc) && shelf_perc.length !== 0) {
                    sum_shelf_perc += parseFloat(shelf_perc);
                    n_shelf_perc++;
                }
            });

            //set the value of currents rows sum to the total-combat element in the current row
            $('.total-shelf_row<?php echo $channel_id; ?>', this).html(parseFloat(sum_shelf / n_shelf).toFixed(2));
            $('.total-perc_row<?php echo $channel_id; ?>', this).html(parseFloat(sum_shelf_perc / n_shelf_perc).toFixed(2));
        }); // End foreach TR
    });
</script>

<script>
    var data_shelf = [];
    var series = [];
    var categories = [];

<?php foreach ($dates as $r) { ?>
        categories.push('<?php echo $r ?>');
<?php } ?>

    console.log(categories);
    var series = [];
<?php foreach ($components as $brand_name => $componentDates) { ?>
        var data_shelf = [];
    <?php foreach ($dates as $date) {
        ?>
            column_shelf =<?php echo $componentDates[$date][0] ?>;
            column_shelf = parseFloat(column_shelf).toFixed(0);
            column_shelf = parseInt(column_shelf, 10);
            data_shelf.push(column_shelf);
    <?php }
    ?>
        series.push(
                {
                    name: '<?php echo str_replace("'", "", $brand_name); ?>',
                    data: data_shelf
                });
    <?php
}
?>
    console.log(series);

    Highcharts.chart('trend_channel<?php echo $channel_id; ?>', {

        title: {
            text: 'SHELF TREND PER BRAND'
        },

        subtitle: {
            text: 'out of stock trend'
        },
        xAxis: {
            categories: categories
        },
        yAxis: {
            title: {
                text: 'SHELF %'
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