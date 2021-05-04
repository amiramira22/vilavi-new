<?php
$zones = array();
$components = array();
$sum_shelf_zone = array();

foreach ($report_data as $row) {
    $zone = $row['zone'];
    if (!in_array($zone, $zones)) {
        $zones[] = $zone;
    }
    //create an array for every brand and the count at a outlet
    $components[$row['product_id']][$zone] = $row['shelf'];
    $components_zone [$row['zone']] [$row['product_id']] = $row['shelf'];
}// end foreach report_data
?>

<div class="table-responsive">
    <table class="table table-bordered table-hover" id="myTable<?php echo $cluster_id; ?>">

        <thead>
            <tr> 
                <th colspan="3"></th>

                <?php foreach ($zones as $zone) { ?>
                    <th class ="text-center" colspan="2">
                        <?php
                        echo $zone;
                        ?>
                    </th>
                <?php } ?>
                <th colspan="2">Total</th>
            </tr>

            <tr>
                <th>Rank</th>
                <th>Brand</th>
                <th>Product</th>

                <?php foreach ($zones as $zone) { ?>
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
            foreach ($components as $product_id => $componentZones) {
                $i++;
                ?>
                <tr>
                    <?php
                    $product = App\Entities\Product::find($product_id);
                    $product_name = $product->name;
                    $brand_name = $product->brand->name;
                    ?>
                    <td class="rank<?php echo $cluster_id; ?>"><b><?php echo $i; ?></b></td>
                    <td><?php echo $brand_name; ?></td>
                    <td><?php echo $product->name; ?></td> 
                    <?php foreach ($zones as $zone) { ?>
                        <td class="shelf_brand<?php echo $cluster_id; ?>">
                            <?php
                            if (isset($componentZones[$zone])) {
                                echo $componentZones[$zone];
                            } else
                                echo '-';
                            ?> </td>

                        <td class="perc_brand<?php echo $cluster_id; ?>">
                            <?php
                            if (isset($componentZones[$zone])) {
                                //echo  ($componentDates[$zone][0]/ $sum_shelf_zone[$zone])*100 .'%';
                                if ($sum_shelf_array[$zone] != 0) {
                                    echo number_format(($componentZones[$zone] / $sum_shelf_array[$zone]) * 100, 2);
                                } else {
                                    echo '0';
                                }
                                // echo $componentDates[$zone][0];
                            } else
                                echo '-';
                            ?> </td>

                    <?php } // end foreach zones   ?>

                    <td class="total-shelf_brand<?php echo $cluster_id; ?>"></td>
                    <td class="total-perc_brand<?php echo $cluster_id; ?>"></td>
                <?php }// end foreach components    ?>
            </tr>
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function () {


        var tot_shelf = 0;
        tot_shelf = <?php echo $sum_shelf; ?>;
        //iterate through each row in the table
        // Total Shelf
        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum_shelf = 0;

            //find the combat elements in the current row and sum it 
            // Calculate Total Shelf for each row
            $(this).find('.shelf_brand<?php echo $cluster_id; ?>').each(function () {
                var shelf = $(this).text();
                var shelf = shelf.replace(",", "");
                if (!isNaN(shelf) && shelf.length !== 0 && shelf > 0) {
                    sum_shelf += parseFloat(shelf);
                }
            });

            $('.total-shelf_brand<?php echo $cluster_id; ?>', this).html(parseFloat(sum_shelf).toFixed(0));
            $('.total-perc_brand<?php echo $cluster_id; ?>', this).html(parseFloat((sum_shelf / tot_shelf) * 100).toFixed(2));

        });// end foreach TR

    });
</script>

<script>
    $(document).ready(function () {

        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("myTable<?php echo $cluster_id; ?>");
        switching = true;
        /*Make a loop that will continue until
         no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
             first, which contains table headers):*/
            for (i = 2; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                 one from current row and one from the next:*/
                x = rows[i].getElementsByClassName("total-shelf_brand<?php echo $cluster_id; ?>");
                y = rows[i + 1].getElementsByClassName("total-shelf_brand<?php echo $cluster_id; ?>");

                //check if the two rows should switch place:
                if (parseInt(x[0].innerHTML.toLowerCase()) < parseInt(y[0].innerHTML.toLowerCase())) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
                rows[2].getElementsByClassName("rank<?php echo $cluster_id; ?>")[0].innerHTML = 1;
                rows[i + 1].getElementsByClassName("rank<?php echo $cluster_id; ?>")[0].innerHTML = i;

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