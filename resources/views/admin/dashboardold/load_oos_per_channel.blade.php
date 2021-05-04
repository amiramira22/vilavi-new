

<div class="m-portlet m-portlet--tabs">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text {{env('iconColor')}}">
                    <i class="flaticon-graphic-2 {{env('iconColor')}}"></i>
                    <span style="padding-left:10px;"></span>
                    OOS PER CHANNEL
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--right m-tabs-line--danger" role="tablist">

                <?php
                foreach ($brands as $brand) {
                    $class = "";
//                    if ($brand->name == 'Main-Brand') {
                    if ($brand->id == env('brand_id')) {

                        $class = "active";
                    } else {
                        $class = "";
                    }
                    ?>
                    <li class="nav-item m-tabs__item">
                        <a href="#tab_<?php echo $brand->id; ?>"
                           id="brand_<?php echo $brand->id; ?>"
                           class="nav-link m-tabs__link <?php echo $class; ?>" 
                           data-toggle="tab"
                           role="tab">  <?php echo $brand->name; ?> </a>
                    </li>


                    <script type="text/javascript">

                        $("#<?php echo 'brand_' . $brand->id; ?>").click(function () {
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $('#oos_per_channel_chart_div_<?php echo $brand->id; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');

                            jQuery.ajax({
                                url: '<?= route('admin.dashboard.load_chart_oos_per_channel') ?>',

                                data: {_token: CSRF_TOKEN, brand_id: "<?php echo $brand->id; ?>"},
                                type: "POST",
                                success: function (data) {
                                    $('#oos_per_channel_chart_div_<?php echo $brand->id; ?>').html(data);
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
            foreach ($brands as $brand) {
//                if ($brand->name == 'Main-Brand') {
                if ($brand->id == env('brand_id')) {

                    $class = "active";
                } else {
                    $class = "";
                }
                ?>
                <style>
                    #oos_per_channel_chart_div_<?php echo $brand->id; ?> {
                        width: 90%;
                        height: 400px;
                    }

                </style>
                <div class="tab-pane <?php echo $class; ?>" id="tab_<?php echo $brand->id; ?>">
                    <div id="oos_per_channel_chart_div_<?php echo $brand->id; ?>"></div>
                </div>  <!--   tab1 content-->
            <?php } ?>

        </div>
    </div>
</div>


<!--{{ $oos_per_channel_data  }}-->

<script>


// Create the chart
    Highcharts.chart('oos_per_channel_chart_div_<?php echo env('brand_id'); ?>', {
        chart: {
            type: 'column'

        },
        title: {
            text: 'Oos Per Channel'
        },

        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'OOS %'
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
            },
            column: {
                borderRadius: 5
            }

        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span>{point.name}</span>: <b>oos : {point.y:.2f}%</b><br/>'
        },

        "series": [
            {
                "name": "Channel",
                "colorByPoint": true,
                "data": <?php echo $oos_per_channel_data; ?>,
                "maxPointWidth": 50
            }
        ],

    });
</script>
<!-- HTML -->
