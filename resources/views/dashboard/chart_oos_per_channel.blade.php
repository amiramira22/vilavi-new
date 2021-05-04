<script>


// Create the chart
    Highcharts.chart('oos_per_channel_chart_div_<?php echo $brand_id; ?>', {
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