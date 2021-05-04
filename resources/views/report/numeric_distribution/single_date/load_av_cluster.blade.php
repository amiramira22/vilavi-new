<?php
$dates = array();
$components = array();
$count_date = 0;

foreach ($report_data as $row) {
    $date = $row['date'];
    if (!in_array($date, $dates)) {
        $dates[] = $date;
        $count_date += 1;
    }
    //create an array for every brand and the count at a outlet
    $components[$row['product_id']][$date] = array($row['av'], $row['oos'], $row['ha']);
}// end foreach report_data
?>


<div class="table-responsive">
    <table class="table">

        <thead>
            <tr>
                <th colspan="2"></th>

                <?php foreach ($dates as $date) { ?>
                    <th class ="text-center" colspan="3">
                        <?php
                        echo format_qmw_date($date_type, $date);
                        ?>
                    </th>
                <?php } ?>
                <th colspan="3">Average</th>
            </tr>

            <tr>

                <th>Brand</th>
                <th style="width: 300px !important;">Product</th>

                <?php foreach ($dates as $date) { ?>
                    <th class ="text-center">AV</th>
                    <th class ="text-center">OOS</th>
                    <th class ="text-center">HA</th>
                <?php } ?>
                <th>AV%</th>
                <th>OOS%</th>
                <th>HA%</th>
            </tr>

        </thead>

        <tbody>

            <?php
            $i = 0;
            foreach ($components as $product_id => $componentDates) {
                $i++;
                $product = App\Entities\Product::find($product_id);
                $product_name = $product->name;
                $brand_name = $product->brand->name;
                ?>
                <tr>
                    <td><?php echo $brand_name; ?></td>
                    <td style="width: 300px !important;"><?php echo $product_name; ?></td>
                    <?php foreach ($dates as $date) { ?>
                        <td class="av_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>"><?php
                            if (isset($componentDates[$date][0])) {
                                echo str_replace(".00", "", number_format($componentDates[$date][0], 2, '.', ''));
                            } else
                                echo '-';
                            ?> 
                        </td>

                        <td class="oos_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>"><?php
                            if (isset($componentDates[$date][1])) {
                                echo str_replace(".00", "", number_format($componentDates[$date][1], 2, '.', ''));
                            } else
                                echo '-';
                            ?> 
                        </td>

                        <td class="ha_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>"><?php
                            if (isset($componentDates[$date][2])) {
                                echo str_replace(".00", "", number_format($componentDates[$date][2], 2, '.', ''));
                            } else
                                echo '-';
                            ?> 
                        </td>
                    <?php } // end foreach dates  ?>

                    <td class="total-av_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>"></td>
                    <td class="total-oos_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>"></td>
                    <td class="total-ha_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>"></td>
                <?php }// end foreach components  ?>


            </tr>

        </tbody>



    </table>
</div>


<script>
    $(document).ready(function () {

        var total_av = 0;
        var total_oos = 0;
        var total_ha = 0;
        var nb_rows = 0;
        $('tr').each(function () {
            nb_rows++;
//the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum_av = 0;
            var sum_oos = 0;
            var sum_ha = 0;
            var n_av = 0
            var n_oos = 0
            var n_ha = 0
//find the combat elements in the current row and sum it 
            $(this).find('.av_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>').each(function () {
                var shelf = $(this).text();
                if (!isNaN(shelf) && shelf.length !== 0) {
                    sum_av += parseFloat(shelf);
                    total_av += sum_av;
                    n_av++;
                }
            });

            $(this).find('.oos_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>').each(function () {
                var perc = $(this).text();

                if (!isNaN(perc) && perc.length !== 0) {
                    sum_oos += parseFloat(perc);
                    total_oos += sum_oos;
                    n_oos++;
                }
            });

            $(this).find('.ha_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>').each(function () {
                var perc = $(this).text();

                if (!isNaN(perc) && perc.length !== 0) {
                    sum_ha += parseFloat(perc);
                    total_ha += sum_ha;
                    n_ha++;
                }
            });

            $('.total-av_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>', this).html(parseFloat(sum_av / n_av).toFixed(2));
            $('.total-oos_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>', this).html(parseFloat(sum_oos / n_oos).toFixed(2));
            $('.total-ha_row<?php echo $cluster_id; ?>_<?php echo $zone_val . '_' . $out_val; ?>', this).html(parseFloat(sum_ha / n_ha).toFixed(2));
        });



    });
</script>