
<script>

    var chart = AmCharts.makeChart("content_channel<?php echo $channel_id; ?>", {
        "type": "pie",
        "theme": "light",
        "dataProvider": <?php echo $report_data; ?>,
        "valueField": "shelf",
        "titleField": "brand_name",
        "titles": [
            {
                "text": "Shelf share",
                "size": 15
            }
        ],
        "outlineAlpha": 0.4,
        "colorField": "brand_color",
        "fontSize": 15,
        "depth3D": 15,
        "balloonText": "[[title]]<br><span style='font-size:15px'><b>[[value]]</b> ([[percents]]%)</span>",
        "angle": 30,
        "legend": {
            "position": "right",
            "marginRight": 0,
            "autoMargins": true
        },
        "export": {
            "enabled": true
        }
    });
</script>