@extends('layouts.admin.template')
@section('content')
<style>

    .m-body .m-content {
        padding: 10px 80px;
    }
    .m-subheader {
        padding: 30px 30px 0 80px;
    }
</style>
<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    COVERAGE<small></small>
                </h3>
            </div>			
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-section__content">
<!--            <style>
                .m-table.m-table--head-bg-brand thead th {
                    background: #a6a6a7 !important;
                    color: #fff;
                    border-bottom: 0;
                    border-top: 0;
                }
            </style>-->
            <div class="table-responsive">
                <table class="table m-table m-table--head-bg-{{env('tableColor')}}" id="totalMe4">
                    <thead>
                        <tr>
                            <th>State</th>
                            <?php foreach ($channels as $ch) { ?>
                                <th><?php echo $ch->name ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($active_outlets as $outlet) { ?>
                            <tr>
                                <th style="font-weight: normal;"><?php echo $outlet->state_name; ?></th>
                                    <?php
                                    foreach ($channels as $ch) {
                                        $channel_name = $ch->name;
                                        ?>
                                    <td><?php echo $outlet->$channel_name; ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>	
    </div>
</div>

<div class="row content_widget">
    <div class="col-md-6" id=""> 
        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h4 class="m-portlet__head-text">
                            DISPATCHING OUTLETS BY STATE
                        </h4>
                    </div>			
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-section__content">
                    <div id="chartdiv" style="height:400px; width:100%;"></div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-6" id=""> 
        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h4 class="m-portlet__head-text">
                            DISPATCHING OUTLETS BY CHANNEL

                        </h4>
                    </div>			
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-section__content">
                    <div id="chartdiv2" style="height:400px; width:100%;"></div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script>

    $(document).ready(function () {
        $('#totalMe4').tableTotal();

    });
</script>


<script>
    var pie_data = [];
    var y;
<?php foreach ($outlets_by_state as $row) { ?>
        y = '<?php   echo ($row['count_outlet'] / $all_outlets) * 100 ; ?>';
        y = parseFloat(y);
        console.log(y);
        pie_data.push(
                {
                    "name": "<?php echo $row['state_name'] ?>",
                    "y": y,
                    "drilldown": "<?php echo $row['state_name'] ?>"
                }

        );
<?php } ?>
    console.log(pie_data);
    Highcharts.chart('chartdiv', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Dispatching outlets by state',
            style: {
                fontSize: '15px'
            }
        },
        subtitle: {
            text: ''
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.1f}%'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },
        "series": [
            {
                "name": "Dispatching outlets by state",
                "colorByPoint": true,
                "data": pie_data
            }
        ],
    });
</script>





<script>
    var pie_data2 = [];
    var y2;
<?php foreach ($outlets_by_channel as $row) { ?>
        y2 = '<?php
   echo ($row['count_outlet'] / $all_outlets) * 100;
    //echo number_format($val, 2, '.', ' ');
    ?>';
        y2 = parseFloat(y2);
        console.log(y2);
        pie_data2.push(
                {
                    "name": "<?php echo $row['channel_name'] ?>",
                    "y": y2,
                    "drilldown": "<?php echo $row['channel_name'] ?>",
                    "color": "<?php echo $row['channel_color'] ?>"

                }

        );
<?php } ?>
    console.log(pie_data);
    Highcharts.chart('chartdiv2', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Dispatching outlets by channel\r\r',
            style: {
                fontSize: '15px'
            }

        },
        subtitle: {
            text: ''
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.1f}%'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },
        "series": [
            {
                "name": "Dispatching outlets by channel",
                "colorByPoint": true,
                "data": pie_data2
            }
        ],
    });
</script>

@endsection