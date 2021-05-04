

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
    console.log(series);
    Highcharts.chart('trend_div_<?php echo $category_id; ?>', {

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

