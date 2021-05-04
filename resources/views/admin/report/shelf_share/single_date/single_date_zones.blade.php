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
                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
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
                                    <th class ="text-center" colspan="3">
                                        <?php
                                        echo $zone;
                                        ?>
                                    </th>
                                <?php } ?>
                                <th colspan="3">Total</th>
                            </tr>

                            <tr>
                                <th>#</th>
                                <th>Brand</th>

                                <?php foreach ($zones as $zone) { ?>
                                    <th>shelf</th>
                                    <th>Metrage</th>
                                    <th>%</th>
                                <?php } ?>
                                <th>shelf</th>
                                <th>Metrage</th>
                                <th>%</th>
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
                                            ?> </td>
                                        <td class="metrage_brand">
                                            <?php
                                            if (isset($componentZones[$zone])) {
                                                echo number_format(($componentZones[$zone][1]), 2, '.', '');
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
                                                if ($sum_metrage_zone[$zone] != 0) {
                                                    echo number_format(($componentZones[$zone][1] / $sum_metrage_zone[$zone]) * 100, 2);
                                                } else {
                                                    echo '0';
                                                }
                                                // echo $componentDates[$zone][0];
                                            } else
                                                echo '-';
                                            ?> </td>

                                    <?php } // end foreach zones   ?>

                                    <td class="total-shelf_brand"></td>
                                    <td class="total-metrage_brand"></td>
                                    <td class="total-perc_brand"></td>
                                <?php }// end foreach components   ?>
                            </tr>

                            <tr>
                                <td colspan="2" align="center">Total</td>
                                <?php foreach ($zones as $zone) { ?>
                                    <td class="sumshelfzone"></td>
                                    <td class="summetragezone"></td>
                                    <td class="sumperczone"></td>
                                <?php } // end foreach zones   ?>
                                <td class="sumshelftotal"></td>
                                <td class="summetragetotal"></td>
                                <td class="sumperctotal"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <br>
                <br>
                <div style="height:900px; width:100%;" id="pie_chart"></div>
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
                                url: '<?= route('admin.report.load_shelf_cluster_zones') ?>',
                                data: {_token: CSRF_TOKEN,
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
                                url: '<?= route('admin.report.load_shelf_zone_pie_chart') ?>',
                                data: {_token: CSRF_TOKEN,
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
    function showchart(data)
    {

        var chart = AmCharts.makeChart("pie_chart", {

            "type": "pie",
            "theme": "light",
            "dataProvider": data,
            "valueField": "metrage",
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

        var chartdata = [];
        var tab_perc = [];
        var tot_metrage = 0;
        tot_metrage = <?php echo $sum_metrage; ?>;
        //iterate through each row in the table
        // Total Shelf
        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum_shelf = 0;
            var sum_metrage = 0;


            //find the combat elements in the current row and sum it 
            // Calculate Total Shelf for each row
            $(this).find('.shelf_brand').each(function () {
                var shelf = $(this).text();
                var shelf = shelf.replace(",", "");
                if (!isNaN(shelf) && shelf.length !== 0 && shelf > 0) {
                    sum_shelf += parseFloat(shelf);
                }
            });
            //set the value of currents rows sum to the total-combat element in the current row
            // Calculate Total Metrage for each row
            $(this).find('.metrage_brand').each(function () {
                var metrage = $(this).text();
                var metrage = metrage.replace(",", "");
                if (!isNaN(metrage) && metrage.length !== 0 && metrage > 0) {
                    sum_metrage += parseFloat(metrage);
                }
            });

            $('.total-shelf_brand', this).html(parseFloat(sum_shelf).toFixed(0));
            $('.total-metrage_brand', this).html(parseFloat(sum_metrage).toFixed(2));
            $('.total-perc_brand', this).html(parseFloat((sum_metrage / tot_metrage) * 100).toFixed(2));

            // Retrieve Brand name
            $(this).find('.brand_brand').each(function () {
                brand = $(this).text();
            });

            // Retrieve color for each brand
            $(this).find('.color_color').each(function () {
                color = $.trim($(this).text());
            });


            //metrage = (parseFloat(sum_metrage / count).toFixed(2));
            if (sum_metrage > 0)
            {
                chartdata.push(
                        {
                            brand_name: brand,
                            color_name: color,
                            metrage: parseFloat(sum_metrage).toFixed(2)
                        }
                )
            }

        });// end foreach TR
        showchart(chartdata);
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
                x = rows[i].getElementsByClassName("total-metrage_brand");
                y = rows[i + 1].getElementsByClassName("total-metrage_brand");

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
<input type="submit" value="" />
<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumshelfzone = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumshelfzone += parseFloat($('td.shelf_brand:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumshelfzone);
            });
        }
        tally('td.sumshelfzone');
    });

</script>


<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var summetragezone = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    summetragezone += parseFloat($('td.metrage_brand:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(summetragezone);
            });
        }
        tally('td.summetragezone');
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
                $(this).html(sumperczone.toFixed(2));
            });
        }
        tally('td.sumperczone');
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
                $(this).html(sumshelftotal);
            });
        }
        tally('td.sumshelftotal');
    });

</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var summetragetotal = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    summetragetotal += parseFloat($('td.total-metrage_brand:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(summetragetotal.toFixed(2));
            });
        }
        tally('td.summetragetotal');
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
                $(this).html(sumperctotal.toFixed(2));
            });
        }
        tally('td.sumperctotal');
    });

</script>