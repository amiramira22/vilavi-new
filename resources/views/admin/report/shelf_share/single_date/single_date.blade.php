<!--SINGLE DATE SHELF SHARE-->
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
                    <table class="table table-bordered table-hover" id="shelf_table">

                        <thead>
                            <tr>
                                <th colspan="2"></th>

                                <?php foreach ($dates as $date) { ?>
                                    <th class ="text-center" colspan="3"><?php echo format_qmw_date($date_type, $date); ?></th>
                                <?php } ?>
                            </tr>

                            <tr>
                                <th>Rank</th>
                                <th>Brand</th>

                                <?php foreach ($dates as $date) { ?>
                                    <th>Shelf</th>    
                                    <th>Metrage</th>                        
                                    <th>%</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $i = 0;
                            foreach ($components as $brand_name => $componentDates) {

                                $i++;
                                ?>
                                <tr>
                                    <td class="rank"><b><?php echo $i; ?></b></td>
                                    <td><?php echo $brand_name; ?></td>

                                    <?php foreach ($dates as $date) { ?>
                                        <td class="shelf" >
                                            <?php
                                            if (isset($componentDates[$date])) {
                                                echo $componentDates[$date][0];
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                        <td class="metrage" >
                                            <?php
                                            if (isset($componentDates[$date])) {
                                                //echo $componentDates[$date][1];
                                                echo number_format(($componentDates[$date][1]), 2, '.', '');
                                                //number_format($total_avg, 2, '.', '');
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                        <td class="perc">
                                            <?php
                                            if (isset($componentDates[$date])) {
                                                echo number_format(($componentDates[$date][1] / $sum_metrage_date[$date]) * 100, 2);
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>


                                    <?php } // end foreach dates       ?>

                                <?php }// end foreach components       ?>
                            <tr>
                                <td colspan="2">Total</td>
                                <td class="totalshelf" id="sum1"></td>
                                <td class="totalmetrage" id="sum3"></td>
                                <td class="totalperc" id="sum2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <br>
                <br>
                <!--<div id="shelf_pie_chart" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>-->
                <div style="height:500px; width:100%;" id="shelf_pie_chart"></div>


            </div>
        </div>
        <!--end::Section-->
    </div>
</div>
<?php
//print_r($report_data);
//print_r($dates);
?>
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
                            $('#content_cluster<?php echo $cluster_id; ?>-1').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                            jQuery.ajax({
                                type: 'post',
                                url: '<?= route('admin.report.load_shelf_cluster') ?>',
                                data: {_token: CSRF_TOKEN,
                                    start_date: "<?php echo $start_date; ?>",
                                    end_date: "<?php echo $end_date; ?>",
                                    category_id: "<?php echo $category_id; ?>",
                                    zone_id: "-1",
                                    channel_id: "-1",
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
<script>

<?php
// pie chart

foreach ($components as $brand_name => $componentDates) {
    foreach ($dates as $date) {
        $total_avg = number_format(($componentDates[$date][1] / $sum_metrage_date[$date]) * 100, 2, '.', '');
        $row_data['name'] = $brand_name;
        $row_data['y'] = $total_avg + 0;
        $brand_color = App\Entities\Brand::where('name', $brand_name)->first()->color;
        $row_data['color'] = $brand_color;
        $data_pie_chart[] = $row_data;
    }
}
$brand_data = json_encode($data_pie_chart);
?>

    console.log(<?php echo $brand_data ?>);
    showchart(<?php echo $brand_data ?>);

    function showchart(data)
    {



        var chart = AmCharts.makeChart("shelf_pie_chart", {
            "type": "pie",
            "theme": "light",
            "dataProvider": data,
            "valueField": "y",
            "titleField": "name",
            "titles": [
                {
                    "text": "Shelf share",
                    "size": 15
                }
            ],
            "outlineAlpha": 0.4,
            "colorField": "color",
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
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var total = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    total += parseFloat($('td.shelf:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(total);
            });
        }
        tally('td.totalshelf');
    });

</script>
<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var totalmetrage = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    totalmetrage += parseFloat($('td.metrage:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(totalmetrage.toFixed(2));
            });
        }
        tally('td.totalmetrage');
    });

</script>

<script>
    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var totalperc = 0,
                        column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    totalperc += parseFloat($('td.perc:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(totalperc.toFixed(2));
            });
        }
        tally('td.totalperc');
    });

</script>
