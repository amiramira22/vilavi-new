<!--SINGLE DATE -->
<?php
//print_r($report_data);
//print_r($dates);
//print_r($components);
//print_r($zones);

?>


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                    @lang('project.SHELF_SHARE_REPORT')
                </h3>
            </div>
        </div>

        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">

                <li class="m-portlet__nav-item"></li>
                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                    m-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#"
                       class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                        Actions
                    </a>

                </li>
            </ul>
        </div>

    </div>
    <div class="m-portlet__body">
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="shelf_zone_table">
                        <thead>
                        <tr>
                            <th colspan="2"></th>
                            <?php foreach ($zones as $zone) { ?>
                            <th class="text-center" colspan="6">
                                <?php
                                echo $zone;
                                ?>
                            </th>
                            <?php } ?>
                            <th colspan="6">Total</th>
                        </tr>

                        <tr>
                            <th>#</th>
                            <th>Brand</th>
                            <?php foreach ($zones as $zone) { ?>
                            <th>shelf</th>
                            <th>%</th>
                            <th>NV chapeau</th>
                            <th>NV yeux</th>
                            <th>NV mains</th>
                            <th>NV pieds</th>
                            <?php } ?>
                            <th>shelf</th>
                            <th>%</th>
                            <th>NV chapeau</th>
                            <th>NV yeux</th>
                            <th>NV mains</th>
                            <th>NV pieds</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        $i = 0;
                        foreach ($components as $brand_name => $componentZones) {
                        $i++;
                        ?>
                        <tr class="data">
                            <td class="rank"><b><?php echo $i; ?></b></td>
                            <td class="brand_brand"><?php echo $brand_name; ?></td>
                            <?php foreach ($zones as $zone) { ?>
                            <td class="shelf_brand">
                                <?php
                                if (isset($componentZones[$zone])) {
                                    echo $componentZones[$zone][0];
                                } else
                                    echo '-';
                                ?>
                            </td>
                            <td class="color_color" style="display: none;">
                                <?php
                                if (isset($componentZones[$zone])) {
                                    echo $componentZones[$zone][2];
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="perc_brand">
                                <?php
                                if (isset($componentZones[$zone])) {
                                    //echo  ($componentDates[$zone][0]/ $sum_shelf_zone[$zone])*100 .'%';
                                    if ($sum_shelf_zone[$zone] != 0) {
                                        echo number_format(($componentZones[$zone][0] / $sum_shelf_zone[$zone]) * 100, 2);
                                    } else {
                                        echo '0';
                                    }
                                    // echo $componentDates[$zone][0];
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="chapeau_brand">
                                <?php
                                if (isset($componentZones[$zone]) && $sum_chapeau_date[$zone] != 0) {
                                    echo number_format(($componentZones[$zone][3] / $sum_chapeau_date[$zone]) * 100, 2);

                                } else
                                    echo '-';
                                ?>
                            </td>
                            <td class="chapeau_brand_num" style="display: none;">
                                <?php
                                if (isset($componentZones[$zone])) {
                                    echo $componentZones[$zone][3];
                                } else
                                    echo '-';
                                ?>
                            </td>
                            <td class="yeux_brand_num" style="display: none;">
                                <?php
                                if (isset($componentZones[$zone])) {
                                    echo $componentZones[$zone][4];
                                } else
                                    echo '-';
                                ?>
                            </td>
                            <td class="main_brand_num" style="display: none;">
                                <?php
                                if (isset($componentZones[$zone])) {
                                    echo $componentZones[$zone][5];
                                } else
                                    echo '-';
                                ?>
                            </td>
                            <td class="pied_brand_num" style="display: none;">
                                <?php
                                if (isset($componentZones[$zone])) {
                                    echo $componentZones[$zone][6];
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="yeux_brand">
                                <?php
                                if (isset($componentZones[$zone]) && $sum_yeux_date[$zone] != 0) {
                                    echo number_format(($componentZones[$zone][4] / $sum_yeux_date[$zone]) * 100, 2);
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="main_brand">
                                <?php
                                if (isset($componentZones[$zone]) && $sum_main_date[$zone] != 0) {
                                    echo number_format(($componentZones[$zone][5] / $sum_main_date[$zone]) * 100, 2);
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <td class="pied_brand">
                                <?php
                                if (isset($componentZones[$zone]) && $sum_pied_date[$zone] != 0) {
                                    echo number_format(($componentZones[$zone][6] / $sum_pied_date[$zone]) * 100, 2);
                                } else
                                    echo '-';
                                ?>
                            </td>

                            <?php } // end foreach zones   ?>

                            <td class="total-shelf_brand"></td>
                            <td class="total-perc_brand"></td>
                            <td class="total-chapeau_brand"></td>
                            <td class="total-yeux_brand"></td>
                            <td class="total-main_brand"></td>
                            <td class="total-pied_brand"></td>
                            <?php }// end foreach components   ?>
                        </tr>

                        <tr>
                            <td colspan="2" align="center">Total</td>
                            <?php foreach ($zones as $zone) { ?>
                            <td class="sumshelfzone"></td>
                            <td class="sumperczone"></td>
                            <td class="sumchapeauzone" id=""></td>
                            <td class="sumyeuxzone" id=""></td>
                            <td class="summainzone" id=""></td>
                            <td class="sumpiedzone" id=""></td>
                            <?php } // end foreach zones   ?>
                            <td class="sumshelftotal"></td>
                            <td class="sumperctotal"></td>
                            <td class="sumchapeautotal" id=""></td>
                            <td class="sumyeuxtotal" id=""></td>
                            <td class="summaintotal" id=""></td>
                            <td class="sumpiedtotal" id=""></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <br>
                <br>
                <div style="height:900px; width:100%;" id="pie_chart"></div>
                <div style="height:500px; width:100%;" id="Niveau-dex-yeux"></div>

            </div>
        </div>
        <!--end::Section-->
    </div>
</div>

<?php
if (!empty($clusters)) {
foreach ($clusters as $cluster) {
$cluster_id = $cluster->id;
$cluster_name = $cluster->name;
?>
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                    <?php echo $cluster_name; ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content" id="content_cluster<?php echo $cluster_id; ?>">
                <script type="text/javascript">

                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var zone_ids = JSON.stringify(<?php echo $json_zone_ids; ?>);
                    var channel_ids = JSON.stringify(<?php echo $json_channel_ids; ?>);
                    $('#content_cluster<?php echo $cluster_id; ?>-1').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                    jQuery.ajax({
                        type: 'post',
                        url: '<?= route('report.load_shelf_cluster_zones') ?>',
                        data: {
                            _token: CSRF_TOKEN,
                            start_date: "<?php echo $start_date; ?>",
                            end_date: "<?php echo $end_date; ?>",
                            category_id: "<?php echo $category_id; ?>",
                            json_zone_ids: zone_ids,
                            json_channel_ids: channel_ids,
                            zone_val: "0",
                            out_val: "0",
                            date_type: "<?php echo $date_type; ?>",
                            cluster_id: "<?php echo $cluster_id; ?>"
                        },

                        success: function (data) {
                            $('#content_cluster<?php echo $cluster_id; ?>').html(data);
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<?php
}
}// end clusters foreach
?>





<!--     Zones              -->
<?php if (!empty($zones)) { ?>

<?php
foreach ($selected_zone_ids as $zone_id) {
//$zone_id = $zone->id;
//$zone_name = $zone->name;
?>

<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                    <?php echo App\Entities\Zone::find($zone_id)->name; ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <!--begin::Section-->
        <div class="m-section">

            <div class="m-section__content" id="content_zone<?php echo $zone_id; ?>" style="height:900px; width:100%;">

                <script type="text/javascript">
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $('#content_zone<?php echo $zone_id; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                    jQuery.ajax({
                        url: '<?= route('report.load_shelf_zone_pie_chart') ?>',
                        data: {
                            _token: CSRF_TOKEN,
                            start_date: "<?php echo $start_date; ?>",
                            end_date: "<?php echo $end_date; ?>",
                            category_id: "<?php echo $category_id; ?>",
                            zone_id: "<?php echo $zone_id; ?>",
                            date_type: "<?php echo $date_type; ?>"

                        },
                        type: "POST",
                        success: function (data) {
                            $('#content_zone<?php echo $zone_id; ?>').html(data);
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<?php } // end clusters foreach      ?>


<?php } // end if(!empty($zones)){  ?>


<script>
    function showchart(data) {

        var chart = AmCharts.makeChart("pie_chart", {

            "type": "pie",
            "theme": "light",
            "dataProvider": data,
            "valueField": "shelf",
            "titleField": "brand_name",
            "titles": [
                {
                    "text": "Shelf share",
                    "size": 15
                }
            ],
            "outlineAlpha": 0.4,
            "colorField": "color_name",
            "fontSize": 16,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:16px'><b>[[value]]</b> ([[percents]]%)</span>",
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
    }

</script>

<script>
    $(document).ready(function () {
        var data_bar_chart = [];
        var chartdata = [];
        var tab_perc = [];

        var tot_shelf = 0;
        tot_shelf = <?php echo $sum_shelf; ?>;

        var tot_chapeau = 0
        tot_chapeau = <?php echo $sum_chapeau; ?>;

        var tot_yeux = 0
        tot_yeux = <?php echo $sum_yeux; ?>;

        var tot_main = 0
        tot_main = <?php echo $sum_main; ?>;

        var tot_pied = 0
        tot_pied = <?php echo $sum_pied; ?>;

        //iterate through each row in the table
        // Total Shelf
        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum_shelf = 0;
            var sum_chapeau = 0;
            var sum_yeux = 0;
            var sum_main = 0;
            var sum_pied = 0;

            //find the combat elements in the current row and sum it 
            // Calculate Total Shelf for each row
            $(this).find('.shelf_brand').each(function () {
                var shelf = $(this).text();
                var shelf = shelf.replace(",", "");
                if (!isNaN(shelf) && shelf.length !== 0 && shelf > 0) {
                    sum_shelf += parseFloat(shelf);
                }
            });

            $(this).find('.chapeau_brand_num').each(function () {
                var chapeau = $(this).text();
                var chapeau = chapeau.replace(",", "");
                if (!isNaN(chapeau) && chapeau.length !== 0 && chapeau > 0) {
                    sum_chapeau += parseFloat(chapeau);
                }
            });

            $(this).find('.yeux_brand_num').each(function () {
                var yeux = $(this).text();
                var yeux = yeux.replace(",", "");
                if (!isNaN(yeux) && yeux.length !== 0 && yeux > 0) {
                    sum_yeux += parseFloat(yeux);
                }
            });


            $(this).find('.main_brand_num').each(function () {
                var main = $(this).text();
                var main = main.replace(",", "");
                if (!isNaN(main) && main.length !== 0 && main > 0) {
                    sum_main += parseFloat(main);
                }
            });

            $(this).find('.pied_brand_num').each(function () {
                var pied = $(this).text();
                var pied = pied.replace(",", "");
                if (!isNaN(pied) && pied.length !== 0 && pied > 0) {
                    sum_pied += parseFloat(pied);
                }
            });

            $('.total-shelf_brand', this).html(parseFloat(sum_shelf).toFixed(0));
            $('.total-perc_brand', this).html(parseFloat((sum_shelf / tot_shelf) * 100).toFixed(2));
            $('.total-chapeau_brand', this).html(parseFloat((sum_chapeau / tot_chapeau) * 100).toFixed(2));
            $('.total-yeux_brand', this).html(parseFloat((sum_yeux / tot_yeux) * 100).toFixed(2));
            $('.total-main_brand', this).html(parseFloat((sum_main / tot_main) * 100).toFixed(2));
            $('.total-pied_brand', this).html(parseFloat((sum_pied / tot_pied) * 100).toFixed(2));

            var color
            var brand
            // Retrieve Brand name
            $(this).find('.brand_brand').each(function () {
                brand = $(this).text();
            });
            // Retrieve color for each brand
            $(this).find('.color_color').each(function () {
                color = $.trim($(this).text());
            });
            //shelf = (parseFloat(sum_shelf / count).toFixed(2));
            if (sum_shelf > 0) {
                chartdata.push(
                    {
                        brand_name: brand,
                        color_name: color,
                        shelf: parseFloat(sum_shelf).toFixed(2)
                    }
                )
            }
            if (brand && color) {
                var obj = {
                    name: brand,
                    color: color,
                    data: [
                        Number(parseFloat((sum_chapeau / tot_chapeau) * 100).toFixed(2) + 0),
                        Number(parseFloat((sum_yeux / tot_yeux) * 100).toFixed(2) + 0),
                        Number(parseFloat((sum_main / tot_main) * 100).toFixed(2) + 0),
                        Number(parseFloat((sum_pied / tot_pied) * 100).toFixed(2) + 0),
                    ],

                }
                data_bar_chart.push(obj)
            }


        });// end foreach TR
        showchart(chartdata);
        showchartBar(data_bar_chart)

        function showchartBar(data) {
            Highcharts.chart('Niveau-dex-yeux', {
                chart: {
                    type: 'column',
                    options3d: {
                        enabled: true,
                        alpha: 15,
                        beta: 15,
                        viewDistance: 25,
                        depth: 40
                    }
                },

                title: {
                    text: 'Niveau des Yeux'
                },

                xAxis: {
                    categories: ['Niveau chapeau', 'Niveau des yeux', 'Niveau des mains', 'Niveau des pieds'],

                    labels: {
                        skew3d: true,
                        style: {
                            fontSize: '16px'
                        }
                    }
                },

                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: '',
                        skew3d: true
                    }
                },

                tooltip: {
                    headerFormat: '<b>{point.key}</b><br>',
                    pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        depth: 40
                    }
                },
                series: data
            })
        }
    });


</script>

<script>
    $(document).ready(function () {

        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("myTable");
        switching = true;
        /*Make a loop that will continue until
         no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByClassName("data");
            /*Loop through all table rows (except the
             first, which contains table headers):*/
            for (i = 0; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                 one from current row and one from the next:*/
                x = rows[i].getElementsByClassName("total-shelf_brand");
                y = rows[i + 1].getElementsByClassName("total-shelf_brand");

                //check if the two rows should switch place:
                if (parseInt(x[0].innerHTML.toLowerCase()) < parseInt(y[0].innerHTML.toLowerCase())) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
                //rows[0].getElementsByClassName("rank")[0].innerHTML = 0;
                rows[i].getElementsByClassName("rank")[0].innerHTML = i + 1;
                rows[i + 1].getElementsByClassName("rank")[0].innerHTML = i + 2;


            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                 and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    });
</script>
<input type="submit" value=""/>
<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumshelfzone = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumshelfzone += parseFloat($('td.shelf_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumshelfzone);
                $(this).html(Math.round(sumshelfzone * 100) / 100);

            });
        }

        tally('td.sumshelfzone');
    });

</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumperczone = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumperczone += parseFloat($('td.perc_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumperczone.toFixed(2));
                $(this).html(Math.round(sumperczone * 100) / 100);

            });
        }

        tally('td.sumperczone');
    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumchapeauzone = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumchapeauzone += parseFloat($('td.chapeau_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumchapeauzone);
                $(this).html(Math.round(sumchapeauzone * 100) / 100);

            });
        }

        tally('td.sumchapeauzone');
    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumyeuxzone = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumyeuxzone += parseFloat($('td.yeux_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumyeuxzone.toFixed(2));
                $(this).html(Math.round(sumyeuxzone * 100) / 100);

            });
        }

        tally('td.sumyeuxzone');
    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var summainzone = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    summainzone += parseFloat($('td.main_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(parseFloat(summainzone.toFixed(2)));
                $(this).html(Math.round(summainzone * 100) / 100);

            });
        }

        tally('td.summainzone');
    });
</script>


<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumpiedzone = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumpiedzone += parseFloat($('td.pied_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumpiedzone);
                $(this).html(Math.round(sumpiedzone * 100) / 100);

            });
        }

        tally('td.sumpiedzone');

    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumshelftotal = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumshelftotal += parseFloat($('td.total-shelf_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumshelftotal);
                $(this).html(Math.round(sumshelftotal * 100) / 100);

            });
        }

        tally('td.sumshelftotal');
    });

</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumperctotal = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumperctotal += parseFloat($('td.total-perc_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumperctotal.toFixed(2));
                $(this).html(Math.round(sumperctotal * 100) / 100);

            });
        }

        tally('td.sumperctotal');
    });

</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumchapeautotal = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumchapeautotal += parseFloat($('td.total-chapeau_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumchapeautotal);
                $(this).html(Math.round(sumchapeautotal * 100) / 100);

            });
        }

        tally('td.sumchapeautotal');
    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumyeuxtotal = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumyeuxtotal += parseFloat($('td.total-yeux_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumyeuxtotal);
                $(this).html(Math.round(sumyeuxtotal * 100) / 100);

            });
        }

        tally('td.sumyeuxtotal');
    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var summaintotal = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    summaintotal += parseFloat($('td.total-main_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(summaintotal);
                $(this).html(Math.round(summaintotal * 100) / 100);

            });
        }

        tally('td.summaintotal');
    });
</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumpiedtotal = 0,
                    column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumpiedtotal += parseFloat($('td.total-pied_brand:eq(' + column + ')', this).html()) || 0;
                })
                //$(this).html(sumpiedtotal);
                $(this).html(Math.round(sumpiedtotal * 100) / 100);

            });
        }

        tally('td.sumpiedtotal');
    });
</script>
