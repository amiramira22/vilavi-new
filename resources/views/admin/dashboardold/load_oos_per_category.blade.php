<div class="m-portlet m-portlet--tabs">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text {{env('iconColor')}}">
                    <i class="flaticon-pie-chart {{env('iconColor')}}"></i>
                    <span style="padding-left:10px;"></span>
                    OOS PER Category
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--right m-tabs-line--danger" role="tablist">
                <?php
                foreach ($brands as $brand_cat) {
                if ($brand_cat->id == env('brand_id')) {
                    $class = "active";
                } else {
                    $class = "";
                }
                ?>

                <li class="nav-item m-tabs__item">
                    <a href="#tab_category{{$brand_cat->id}}"
                       id="brand_cat{{$brand_cat->id}}"
                       class="nav-link m-tabs__link <?php echo $class; ?>"
                       data-toggle="tab"
                       role="tab">  <?php echo $brand_cat->name; ?> </a>
                </li>


                <script type="text/javascript">

                    $("#<?php echo 'brand_cat' . $brand_cat->id; ?>").click(function () {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $('#chartdiv_category_{{$brand_cat->id}}').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');

                        jQuery.ajax({
                            url: '<?= route('admin.dashboard.load_chart_oos_per_category') ?>',
                            data: {_token: CSRF_TOKEN, brand_id: "{{$brand_cat->id}}"},
                            type: "POST",
                            success: function (data) {
                                $('#chartdiv_category_{{$brand_cat->id}}').html(data);
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
            foreach ($brands as $brand_cat) {
            //                if ($brand_cat->name == 'Main-Brand') {
            if ($brand_cat->id == env('brand_id')) {
                $class = "active";
            } else {
                $class = "";
            }
            ?>
            <style>
                #chartdiv_category_{{$brand_cat->id}}  {
                    width: 90%;
                    height: 400px;
                }

            </style>
            <div class="tab-pane <?php echo $class; ?>" id="tab_category{{$brand_cat->id}}">
                <div id="chartdiv_category_{{$brand_cat->id}}"
                     name="chartdiv_category_{{$brand_cat->id}}" #chartdivCategory></div>
            </div>
            <!--   tab1 content-->
            <?php } ?>
        </div>
    </div>
</div>


<?php //print_r($oos_per_category_data); ?>


<script>
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    //var chart = am4core.create("#chartdiv_category_1", am4charts.RadarChart);
    const chart = am4core.create("chartdiv_category_1", am4charts.XYChart);

    // Add data
    chart.data = <?php echo $oos_per_category_data ?>;
    var count = Object.keys(chart.data).length;
    console.log(count);
    const avColors = [];
    const oosColors = [];
    const labelColors = [];

    chart.data.forEach(function (element) {
        avColors.push("#2fb45a");
        oosColors.push("#ec0928");
        labelColors.push("#0968a8");


    });
    console.log(avColors);
    console.log(oosColors);


    // Make chart not full circle
    chart.startAngle = -90;
    chart.endAngle = 180;
    chart.innerRadius = am4core.percent(30);

    // Set number format
    chart.numberFormatter.numberFormat = "#.#'%'";
    //chart.colors.step = 5;
    // Create axes
    var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "category";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.grid.template.strokeOpacity = 0;
    categoryAxis.renderer.labels.template.horizontalCenter = "right";
    categoryAxis.renderer.labels.template.fontWeight = 500;
    categoryAxis.renderer.labels.template.adapter.add("fill", function (fill, target) {
//        return (target.dataItem.index >= 0) ? chart.colors.getIndex(target.dataItem.index) : fill;
        return am4core.color(labelColors[target.dataItem.index]);
    });


    categoryAxis.renderer.minGridDistance = 10;

    var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
    valueAxis.renderer.grid.template.strokeOpacity = 0;
    valueAxis.min = 0;
    valueAxis.max = 100;
    valueAxis.strictMinMax = true;
    valueAxis.renderer.minGridDistance = 10000;
    // Create series
    var series1 = chart.series.push(new am4charts.RadarColumnSeries());
    series1.dataFields.valueX = "full";
    series1.dataFields.categoryY = "category";
    series1.clustered = false;
    //series1.columns.template.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");

    series1.columns.template.adapter.add("fill", function (fill, target) {
        return am4core.color(avColors[target.dataItem.index]);
    });
    series1.columns.template.fillOpacity = 1;
    series1.columns.template.cornerRadiusTopLeft = 20;
    series1.columns.template.strokeWidth = 0;
    series1.columns.template.tooltipText = "{category}: [bold] Av: {av}[/]";
    series1.columns.template.radarColumn.cornerRadius = 5;


    var series2 = chart.series.push(new am4charts.RadarColumnSeries());
    series2.dataFields.valueX = "oos";
    series2.dataFields.categoryY = "category";
    series2.clustered = false;
    series2.columns.template.strokeWidth = 0;
    series2.columns.template.tooltipText = "{category} [bold] Oos: {oos}[/]";
    series2.columns.template.radarColumn.cornerRadius = 5;

    series2.columns.template.adapter.add("fill", function (fill, target) {
        return am4core.color(oosColors[target.dataItem.index]);
    });


</script>

<!-- HTML -->
