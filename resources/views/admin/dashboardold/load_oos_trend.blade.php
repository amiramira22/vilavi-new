<?php //dd($components); 
//dd($categories);
?>
<?php //print_r()  ?>
<div class="m-portlet m-portlet--tabs">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text {{env('iconColor')}}">

                    <i class="flaticon-graph {{env('iconColor')}}"></i>
                    <span style="padding-left:10px;"></span>
                    OOS Trend
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--right m-tabs-line--danger" role="tablist">


                <?php
                $class = "active";
                foreach ($categories as $category) {
                    if ($category->id == env('default_trend_category')) {
                        $class = "active";
                    } else {
                        $class = "";
                    }
                    ?>
                    <li class="nav-item m-tabs__item <?php echo $class; ?>"
                        id="category_<?php echo $category->id; ?>">
                        <a href="#tab10_<?php echo $category->id; ?>"
                           class="nav-link m-tabs__link <?php echo $class; ?>"
                           data-toggle="tab" 
                           role="tab"> <?php echo $category->abrev_name; ?> </a>
                    </li>


                    <script type="text/javascript">

                        $("#<?php echo 'category_' . $category->id; ?>").click(function () {

                            $('#trend_div_<?php echo $category->id; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');
                            jQuery.ajax({
                                url: '<?= route('admin.dashboard.load_chart_oos_trend') ?>',
                                data: {_token: CSRF_TOKEN, category_id: "<?php echo $category->id; ?>"},
                                type: "POST",
                                success: function (data) {
                                    $('#trend_div_<?php echo $category->id; ?>').html(data);
                                }
                            });
                        });
                    </script>


<?php } ?>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="tab-content">
            <?php
            foreach ($categories as $category) {
                ?>
            <script>console.log('$category',<?php echo $category->id;
                                             echo env('default_trend_category') ?>)
            </script>
            <?php
                $class = "active";
                if ($category->id == env('default_trend_category')) {
                    $class = "active";
                } else {
                    $class = "";
                }
                ?>

                <div class="tab-pane <?php echo $class; ?>" id="tab10_<?php echo $category->id; ?>">
                    <div style="height:305px; width:100%;"
                         id="trend_div_<?php echo $category->id; ?>"
                         name="trend_div_<?php echo $category->id; ?>">
                    </div>
                </div>

<?php } ?>
        </div>
    </div>
</div>

<script>
    var data_oos = [];
    var series = [];
    var categories = [];
        <?php foreach ($dates as $r) { ?>
        categories.push('<?php echo $r ?>');
        <?php } ?>


    var series = [];
        <?php foreach ($components as $brand_name => $componentDates) { ?>
        var data_oos = [];
    <?php foreach ($dates as $date) {
        ?>
            column_oos =<?php echo $componentDates[$date][0] ?>;
            column_oos = parseFloat(column_oos).toFixed(0);
            column_oos = parseFloat(column_oos);
            data_oos.push(column_oos);
    <?php }
    ?>
        series.push(
                {
                    name: '<?php echo str_replace("'", "", $brand_name); ?>',
                    data: data_oos,
                    color: '<?php echo $componentDates[$date][1] ?>'
                });
    <?php
}
?>

    Highcharts.chart('trend_div_<?php env('default_trend_category') ?>', {

        title: {
            text: 'OOS TREND'
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
                    connectorAllowed: false,
                    enabled: false
                }
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


