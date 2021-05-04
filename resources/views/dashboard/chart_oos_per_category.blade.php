

<script>
// Themes begin
    am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
    var chart = am4core.create("chartdiv_category_<?php echo $brand_id ?>", am4charts.RadarChart);

// Add data
    chart.data = <?php echo $oos_per_category_data ?>;
//    var count = Object.keys(chart.data).length;
//    console.log(count);
//    const avColors = [];
//    const oosColors = [];
//    chart.data.forEach(function (element) {
//        avColors.push("#2fb45a");
//        oosColors.push("#ec0928");
//
//    });
//    console.log(avColors);


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
//    series2.columns.template.adapter.add("fill", function (fill, target) {
//        return chart.colors.getIndex(target.dataItem.index);
//    });
    series1.columns.template.fillOpacity = 1;
    series1.columns.template.cornerRadiusTopLeft = 20;
    series1.columns.template.strokeWidth = 0;
    series1.columns.template.tooltipText = "{category}: [bold] Av: {av}[/]";
    series1.columns.template.radarColumn.cornerRadius =5;


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
