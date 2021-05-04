

<div class="m-portlet m-portlet--tabs" style="height:389px">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text text-danger">
                    <i class="flaticon-pie-chart text-danger"></i>
                    <span style="padding-left:10px;"></span>
                    Stock Issue
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--right m-tabs-line--danger" role="tablist">


                <?php
                foreach ($brands as $brand) { ?>

                    <?php

//                    if ($brand->name == 'Main-Brand') {
                    if ($brand->id == 1) {
                        $class = "active";
                    } else {
                        $class = "";
                    }
                    ?>
                    <li class="nav-item m-tabs__item">
                        <a href="#tab_numeric_distribution<?php echo $brand->id; ?>"
                           id="numeric_distribution<?php echo $brand->id; ?>"
                           class="nav-link m-tabs__link <?php echo $class; ?>"
                           data-toggle="tab"
                           role="tab">  <?php echo $brand->name; ?> </a>
                    </li>


                    <script type="text/javascript">

                        $("#numeric_distribution<?php echo $brand->id; ?>").click(function () {
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $('#numeric_distribution_chart_div_<?php echo $brand->id; ?>').html('<div class="col-md-12" align="center"><img width="120px" ' +
                                'src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');

                            jQuery.ajax({
                                url: '<?= route('dashboard.load_chart_numeric_distribution') ?>',

                                data: {_token: CSRF_TOKEN, brand_id: "<?php echo $brand->id; ?>"},
                                type: "POST",
                                success: function (data) {
                                    $('#numeric_distribution_chart_div_<?php echo $brand->id; ?>').html(data);
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
                if ($brand->id == 1) {
                    $class = "active";
                } else {
                    $class = "";
                }
                ?>
                <style>
                    #numeric_distribution_chart_div_<?php echo $brand->id; ?> {
                        width: 100%;
                        height: 300px;
                    }

                </style>
                <div class="tab-pane <?php echo $class; ?>" id="tab_numeric_distribution<?php echo $brand->id; ?>">
                    <div id="numeric_distribution_chart_div_<?php echo $brand->id; ?>"
                         name="numeric_distribution_chart_div_<?php echo $brand->id; ?>"></div>
                </div>  <!--   tab1 content-->
            <?php } ?>


        </div>
    </div>
</div>


<?php //echo $numeric_distribution_data  ?>
<!--<script>
// Themes begin
    am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
    var chart = am4core.create("numeric_distribution_chart_div_1", am4charts.PieChart);

// Add data
    chart.data =<?php //echo $numeric_distribution_data ?>;

// Set inner radius
    chart.innerRadius = am4core.percent(50);

// Add and configure Series
    var pieSeries = chart.series.push(new am4charts.PieSeries());

    pieSeries.dataFields.value = "value";
    pieSeries.dataFields.category = "title";
    pieSeries.slices.template.stroke = am4core.color("#fff");
    pieSeries.slices.template.strokeWidth = 2;
    pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
    pieSeries.hiddenState.properties.opacity = 1;
    pieSeries.hiddenState.properties.endAngle = -90;
    pieSeries.hiddenState.properties.startAngle = -90;
    pieSeries.colors.list = [
//        am4core.color("#fbb900"),
        am4core.color("#2fb45a"),
        am4core.color("#ec0928")

    ];
</script>-->



<script>
// Themes begin
    am4core.useTheme(am4themes_animated);
// Themes end

    var chart = am4core.create("numeric_distribution_chart_div_1", am4charts.PieChart);
    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

    chart.data = <?php echo $numeric_distribution_data ?>;
    chart.radius = am4core.percent(65);
    chart.innerRadius = am4core.percent(40);
    chart.startAngle = 180;
    chart.endAngle = 360;

    var series = chart.series.push(new am4charts.PieSeries());
    series.dataFields.value = "value";
    series.dataFields.category = "title";

    series.slices.template.cornerRadius = 3;
    series.slices.template.innerCornerRadius = 3;
    series.slices.template.draggable = true;
    series.slices.template.inert = true;
    series.alignLabels = false;

    series.hiddenState.properties.startAngle = 90;
    series.hiddenState.properties.endAngle = 90;
//    series.colors.step = 6;

//    chart.legend = new am4charts.Legend();

    series.colors.list = [
//        am4core.color("#fbb900"),
        am4core.color("#2fb45a"),
        am4core.color("#ec0928")

    ];
//    chart.exporting.menu = new am4core.ExportMenu();

</script>

<!-- HTML -->
