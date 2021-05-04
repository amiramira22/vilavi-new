<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                </h3>    @lang('project.SHELF_SHARE_REPORT')
            </div>
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
                                    <th class ="text-center" colspan="2">
                                        <?php
                                        //echo $date_type;
                                        echo format_qmw_date($date_type, $date);
                                        ?>
                                    </th>
                                <?php } ?>
                                <th class ="text-center" colspan="2">Average</th>
                            </tr>

                            <tr>

                                <th>Brand</th>

                                <?php foreach ($dates as $date) { ?>
                                    <th class ="text-center">Shelf</th>
                                    <th class ="text-center">%</th>
                                <?php } ?>
                                <th class ="text-center">Shelf%</th>
                                <th class ="text-center">%</th>
                            </tr>

                        <thead>

                        <tbody>

                            <?php
                            $i = 0;
                            foreach ($components as $brand_name => $componentDates) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $brand_name; ?></td>
                                    <?php foreach ($dates as $date) { ?>
                                        <td class="shelf" >
                                            <?php
                                            if (isset($componentDates[$date])) {
                                                echo $componentDates[$date];
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>



                                        <td class="perc">
                                            <?php
                                            if (isset($componentDates[$date])) {
                                                echo number_format(($componentDates[$date] / $sum_shelf_date[$date]) * 100, 2);
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                    <?php } // end foreach dates        ?>

                                    <td class="total-shelf_row"></td>
                                    <td class="total-perc_row"></td>
                                <?php }// end foreach components   ?>
                            </tr>

                            <tr>
                                <td align="center">Total</td>
                                <?php foreach ($dates as $date) { ?>
                                    <td class="sumshelfdate"></td>
                                    <td class="sumpercdate"></td>
                                <?php } // end foreach zones   ?>
                                <td class="sumshelftotal"></td>
                                <td class="sumperctotal"></td>
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
                                url: '<?= route('admin.report.load_shelf_cluster') ?>',
                                data: {_token: CSRF_TOKEN,
                                    start_date: "<?php echo $start_date; ?>",
                                    end_date: "<?php echo $end_date; ?>",
                                    date_type: "<?php echo $date_type; ?>",
                                    category_id: "<?php echo $category_id; ?>",
                                    cluster_id: "<?php echo $cluster_id; ?>",
                                    zone_id: "-1",
                                    channel_id: "-1",
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


<script>

    $(document).ready(function () {
        //iterate through each row in the table
        var bvm_av = 0;
        var bvm_oos = 0;
        $('tr').each(function () {


            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum_av = 0;
            var sum_oos = 0;
            var n_av = 0;
            var n_oos = 0;
            brand = $(this).find('.brand').text();
            //find the combat elements in the current row and sum it 
            $(this).find('.shelf').each(function () {
                var av = $(this).text();
                if (!isNaN(av) && av.length !== 0) {
                    sum_av += parseFloat(av);
                    n_av++;
                }
            });
            $(this).find('.perc').each(function () {
                var oos = $(this).text();
                if (!isNaN(oos) && oos.length !== 0) {
                    sum_oos += parseFloat(oos);
                    n_oos++;
                }
            });
            if (brand == "Main-Brand") {
                bvm_av = sum_av;
                bvm_oos = sum_oos;
            }
            //set the value of currents rows sum to the total-combat element in the current row
            $('.total-shelf_row', this).html(parseFloat(sum_av / n_av).toFixed(2));
            $('.total-perc_row', this).html(parseFloat(sum_oos / n_oos).toFixed(2))
        }); // End foreach TR

    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumshelfzone = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumshelfzone += parseFloat($('td.shelf:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumshelfzone.toFixed(2));
            });
        }
        tally('td.sumshelfdate');
    });</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumperczone = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumperczone += parseFloat($('td.perc:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumperczone.toFixed(0));
            });
        }
        tally('td.sumpercdate');
    });</script>


<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumshelftotal = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumshelftotal += parseFloat($('td.total-shelf_row:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumshelftotal.toFixed(2));
            });
        }
        tally('td.sumshelftotal');
    });</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumperctotal = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumperctotal += parseFloat($('td.total-perc_row:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumperctotal.toFixed(2));
            });
        }
        tally('td.sumperctotal');
    });

</script>



<?php //print_r($dates); ?>
<script>
    var data_shelf = [];
    var series = [];
    var categories = [];

<?php foreach ($dates as $date) { ?>
        categories.push('<?php echo $date ?>');
<?php } ?>

    console.log(categories);
    var series = [];
<?php foreach ($components as $brand_name => $componentDates) { ?>
        var data_shelf = [];
    <?php foreach ($dates as $date) {
        ?>
            column_shelf =<?php echo $componentDates[$date] ?>;
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

