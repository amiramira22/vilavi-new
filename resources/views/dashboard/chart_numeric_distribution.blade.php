<script>
// Themes begin
    am4core.useTheme(am4themes_animated);
// Themes end

    var chart = am4core.create("numeric_distribution_chart_div_<?php echo $brand_id ?>", am4charts.PieChart);
    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

    chart.data = <?php echo $numeric_distribution_data ?>;
    chart.radius = am4core.percent(65);
    chart.innerRadius = am4core.percent(40);
    chart.startAngle = 180;
    chart.endAngle = 360;

    var series = chart.series.push(new am4charts.PieSeries());
    series.dataFields.value = "value";
    series.dataFields.category = "title";

    series.slices.template.cornerRadius = 5;
    series.slices.template.innerCornerRadius = 5;
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