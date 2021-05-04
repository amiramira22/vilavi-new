<!--SINGLE DATE -->
<?php
//print_r($report_data);
//print_r($dates);
//print_r($components);
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
                    <div class="m-dropdown__wrapper" style="z-index: 101;">
                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 36px;"></span>
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">
                                        <li class="m-nav__section m-nav__section--first">
                                            <span class="m-nav__section-text">Export Tools</span>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="#" class="m-nav__link" id="export_print">
                                                <i class="m-nav__link-icon fas fa-print"></i>
                                                <span class="m-nav__link-text">Print</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="#" class="m-nav__link" id="export_copy">
                                                <i class="m-nav__link-icon fas fa-copy"></i>
                                                <span class="m-nav__link-text">Copy</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="#" class="m-nav__link" id="export_excel">
                                                <i class="m-nav__link-icon fas fa-file-excel-o"></i>
                                                <span class="m-nav__link-text">Excel</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="#" class="m-nav__link" id="export_csv">
                                                <i class="m-nav__link-icon fas fa-file-text-o"></i>
                                                <span class="m-nav__link-text">CSV</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="#" class="m-nav__link" id="export_pdf">
                                                <i class="m-nav__link-icon fas fa-file-pdf-o"></i>
                                                <span class="m-nav__link-text">PDF</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

    </div>
    <div class="m-portlet__body">
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="shelf_channel_table">
                        <thead>
                            <tr>
                                <th colspan="2"></th>

                                <?php foreach ($channels as $channel) { ?>
                                    <th class ="text-center" colspan="2">
                                        <?php
                                        echo $channel;
                                        ?>
                                    </th>
                                <?php } ?>
                                <th colspan="2">Total</th>
                            </tr>

                            <tr>
                                <th>Rank</th>
                                <th>Brand</th>

                                <?php foreach ($channels as $channel) { ?>
                                    <th>shelf</th>
                                    <th>%</th>
                                <?php } ?>
                                <th>shelf</th>
                                <th>%</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            $i = 0;
                            foreach ($components as $brand_name => $componentChannels) {
                                $i++;
                                ?>
                                <tr class="data">

                                    <td class="rank"><b><?php echo $i; ?></b></td>
                                    <td class="brand_brand"><?php echo $brand_name; ?></td> 
                                    <?php foreach ($channels as $channel) { ?>
                                        <td class="shelf_brand">
                                            <?php
                                            if (isset($componentChannels[$channel])) {
                                                echo $componentChannels[$channel][0];
                                            } else
                                                echo '-';
                                            ?> </td>


                                        <td class="color_color" style="display: none;">
                                            <?php
                                            if (isset($componentChannels[$channel])) {
                                                echo $componentChannels[$channel][1];
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                        <td class="perc_brand">
                                            <?php
                                            if (isset($componentChannels[$channel])) {
                                                //echo  ($componentDates[$channel][0]/ $sum_shelf_channel[$channel])*100 .'%';
                                                if ($sum_shelf_channel[$channel] != 0) {
                                                    echo number_format(($componentChannels[$channel][0] / $sum_shelf_channel[$channel]) * 100, 2);
                                                } else {
                                                    echo '0';
                                                }
                                                // echo $componentDates[$channel][0];
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                    <?php } // end foreach channels    ?>

                                    <td class="total-shelf_brand"></td>
                                    <td class="total-perc_brand"></td>
                                <?php }// end foreach components    ?>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">Total</td>
                                <?php foreach ($channels as $channel) { ?>
                                    <td class="sumshelfchannel"></td>
                                    <td class="sumpercchannel"></td>
                                <?php } // end foreach channels   ?>
                                <td class="sumshelftotal"></td>
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
                    <div class="m-section__content" id="content_cluster<?php echo $cluster_id; ?>-1">
                        <script type="text/javascript">

                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            var zone_ids = JSON.stringify(<?php echo $json_zone_ids; ?>);
                            var channel_ids = JSON.stringify(<?php echo $json_channel_ids; ?>);

                            $('#content_cluster<?php echo $cluster_id; ?>-1').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                            jQuery.ajax({
                                type: 'post',
                                url: '<?= route('admin.report.load_shelf_cluster_channels') ?>',
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
                                    $('#content_cluster<?php echo $cluster_id; ?>-1').html(data);
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
<?php if (!empty($channels)) { ?>

    <?php
    foreach ($selected_channel_ids as $channel_id) {
        ?>

        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                            <?php echo App\Entities\Channel::find($channel_id)->name; ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="m-section">

                    <div class="m-section__content" id="content_channel<?php echo $channel_id; ?>" style="height:900px; width:100%;">

                        <script type="text/javascript">
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                            $('#content_zone<?php echo $channel_id; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                            jQuery.ajax({
                                url: '<?= route('admin.report.load_shelf_channel_pie_chart') ?>',
                                data: {_token: CSRF_TOKEN,
                                    start_date: "<?php echo $start_date; ?>",
                                    end_date: "<?php echo $end_date; ?>",
                                    category_id: "<?php echo $category_id; ?>",
                                    channel_id: "<?php echo $channel_id; ?>",
                                    date_type: "<?php echo $date_type; ?>"
                                },
                                type: "POST",
                                success: function (data) {
                                    $('#content_channel<?php echo $channel_id; ?>').html(data);
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

    <?php } // end clusters foreach       ?>


<?php } // end if(!empty($zones)){   ?>




<script>
    function showchart(data)
    {

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
    }

</script>

<script>
    $(document).ready(function () {

        var chartdata = [];
        var tot_shelf = 0;
        tot_shelf = <?php echo $sum_shelf; ?>;
        //iterate through each row in the table
        // Total Shelf
        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum_shelf = 0;


            //find the combat elements in the current row and sum it 
            // Calculate Total Shelf for each row
            $(this).find('.shelf_brand').each(function () {
                var shelf = $(this).text();
                var shelf = shelf.replace(",", "");
                if (!isNaN(shelf) && shelf.length !== 0 && shelf > 0) {
                    sum_shelf += parseFloat(shelf);
                }
            });

            $('.total-shelf_brand', this).html(parseFloat(sum_shelf).toFixed(0));
            $('.total-perc_brand', this).html(parseFloat((sum_shelf / tot_shelf) * 100).toFixed(2));

            // Retrieve Brand name
            $(this).find('.brand_brand').each(function () {
                brand = $(this).text();
            });

            // Retrieve color for each brand
            $(this).find('.color_color').each(function () {
                color = $.trim($(this).text());
            });

//AMIRA
            $(this).find('.total-perc_brand').each(function () {
                y = ($(this).text());
            });

            if (sum_shelf > 0)
            {
                chartdata.push(
                        {
                            brand_name: brand,
                            color_name: color,
                            shelf: parseFloat(y).toFixed(2)
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
        table = document.getElementById("shelf_channel_table");
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




<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumshelfchannel = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumshelfchannel += parseFloat($('td.shelf_brand:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumshelfchannel);
            });
        }
        tally('td.sumshelfchannel');
    });

</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumpercchannel = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumpercchannel += parseFloat($('td.perc_brand:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumpercchannel.toFixed(0));
            });
        }
        tally('td.sumpercchannel');
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
                var sumperctotal = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumperctotal += parseFloat($('td.total-perc_brand:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumperctotal.toFixed(0));
            });
        }
        tally('td.sumperctotal');
    });

</script>


<!--

<script>
    $(document).ready(function () {

        var sumshelfchannel = 0;
        var sumpercchannel = 0;
        var sumshelftotal = 0;
        var sumperctotal = 0;




        $("#shelf_channel_table tr").not(':first').not(':last').each(function () {
            $(this).find('.shelf_brand').each(function () {
                var av = $(this).text();
                if (!isNaN(av) && av.length !== 0) {
                    sumshelfchannel += parseFloat(av);

                }
            });

            $(this).find('.perc_brand').each(function () {
                var av = $(this).text();
                if (!isNaN(av) && av.length !== 0) {
                    sumpercchannel += parseFloat(av);

                }
            });

            $(this).find('.total-shelf_brand').each(function () {
                var av = $(this).text();
                if (!isNaN(av) && av.length !== 0) {
                    sumshelftotal += parseFloat(av);

                }
            });
            $(this).find('.total-perc_brand').each(function () {
                var av = $(this).text();
                if (!isNaN(av) && av.length !== 0) {
                    sumperctotal += parseFloat(av);

                }
            });

        });
        $('.sumshelfchannel', this).html(parseFloat(sumshelfchannel).toFixed(0));
        $('.sumpercchannel', this).html(parseFloat(sumpercchannel).toFixed(0));
        $('.sumshelftotal', this).html(parseFloat(sumshelftotal).toFixed(0));
        $('.sumperctotal', this).html(parseFloat(sumperctotal).toFixed(0));




    });

</script>
-->
