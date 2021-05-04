<?php
//dd($report_data);
$dates = array();
$components = array();
$count_date = 0;
$components_date = array();

foreach ($report_data as $row) {
    $date = ($row['date']);
    if (!in_array($date, $dates)) {
        $dates[] = $date;
        $count_date += 1;
    }
    //create an array for every brand and the count at a outlet
    $components[$row['product_id']][$date] = array(
        $row['shelf']
    , $row['metrage']
    , $row['chapeau']
    , $row['yeux']
    , $row['main']
    , $row['pied']
    );
    //$components_date [$row['date']] [$row['product_id']] = $row['metrage'];
    $components_date [$row['date']] [$row['product_id']] = $row['shelf'];

    $components_date_chapeau[$row['date']] [$row['product_id']] = $row['chapeau'];
    $components_date_yeux[$row['date']] [$row['product_id']] = $row['yeux'];
    $components_date_main[$row['date']] [$row['product_id']] = $row['main'];
    $components_date_pied[$row['date']] [$row['product_id']] = $row['pied'];
}// end foreach report_data

$sum_chapeau_date = array();
$sum_yeux_date = array();
$sum_main_date = array();
$sum_pied_date = array();

foreach ($components_date as $date => $componentBrand) {
    $sum_shelf[$date] = array_sum(array_values($componentBrand));
}

foreach ($components_date_chapeau as $date => $componentBrand) {
    $sum_chapeau_date[$date] = array_sum(array_values($componentBrand));
}
foreach ($components_date_yeux as $date => $componentBrand) {
    $sum_yeux_date[$date] = array_sum(array_values($componentBrand));
}
foreach ($components_date_main as $date => $componentBrand) {
    $sum_main_date[$date] = array_sum(array_values($componentBrand));
}
foreach ($components_date_pied as $date => $componentBrand) {
    $sum_pied_date[$date] = array_sum(array_values($componentBrand));
}


?>

<table class="table table-bordered table-hover dt-responsive" width="100%">
    <thead>
    <tr>
        <th colspan="3"></th>
        <?php
        foreach ($dates as $date) {
        if (isset($channel)) {
        ?>
        <th colspan="6"><?php echo format_quarter($date); ?></th>
        <?php } else { ?>
        <th colspan="6"><?php echo format_quarter($date); ?></th>
        <?php
        }
        }
        ?>
        <th class="text-center" colspan="6">Average</th>
    </tr>

    <tr>
        <th></th>
        <th></th>
        <th></th>
        <?php foreach ($dates as $date) { ?>
        <th></th>
        <th></th>
        <th colspan="4"> Niveau des yeux</th>
        <?php } ?>
        <th></th>
        <th></th>
        <th colspan="4"> Niveau des yeux</th>
    </tr>
    <tr>
        <th>Rank</th>
        <th>Brand</th>
        <th>Product</th>
        <?php foreach ($dates as $date) { ?>
        <th>Shelf</th>
        <th>%</th>
        <th>chapeau</th>
        <th> yeux</th>
        <th> mains</th>
        <th> pieds</th>
        <?php } ?>
        <th>Shelf</th>
        <th>%</th>
        <th> chapeau</th>
        <th> yeux</th>
        <th> mains</th>
        <th> pieds</th>
    </tr>

    <thead>

    <tbody>

    <?php
    $i = 0;
    foreach ($components as $product_id => $componentDates) {
    $i++;
    ?>
    <tr>
        <?php
        $product = App\Entities\ProductGroup::find($product_id);
        $brand_id = $product->brand_id;
        $brand_name = App\Entities\Brand::find($brand_id)->name;
        ?>
        <td><b><?php echo $i; ?></b></td>
        <td><?php echo $brand_name; ?></td>
        <td><?php echo $product->name; ?></td>

        <?php foreach ($dates as $date) { ?>
        <td class="shelf">
            <?php
            if (isset($componentDates[$date])) {
                echo $componentDates[$date][0];
            } else
                echo '-';
            ?> </td>
        <td class="perc">
            <?php
            if (isset($componentDates[$date])) {
                if ($sum_shelf[$date] > 0) {
                    echo number_format(($componentDates[$date][0] / $sum_shelf[$date]) * 100, 2);
                } else {
                    echo ' 0';
                }
            } else
                echo '-';
            ?>
        </td>
        <td class="chapeau">
            <?php
            if (isset($componentDates[$date]) && $sum_chapeau_date[$date] != 0) {
                echo number_format(($componentDates[$date][2] / $sum_chapeau_date[$date]) * 100, 2);

            } else
                echo '-';
            ?>
        </td>

        <td class="yeux">
            <?php
            if (isset($componentDates[$date]) && $sum_yeux_date[$date] != 0) {
                echo number_format(($componentDates[$date][3] / $sum_yeux_date[$date]) * 100, 2);
            } else
                echo '-';
            ?>
        </td>

        <td class="main">
            <?php
            if (isset($componentDates[$date]) && $sum_main_date[$date] != 0) {
                echo number_format(($componentDates[$date][4] / $sum_main_date[$date]) * 100, 2);
            } else
                echo '-';
            ?>
        </td>

        <td class="pied">
            <?php
            if (isset($componentDates[$date]) && $sum_pied_date[$date] != 0) {
                echo number_format(($componentDates[$date][5] / $sum_pied_date[$date]) * 100, 2);
            } else
                echo '-';
            ?>
        </td>

        <?php } // end foreach dates    ?>
        <td class="total-shelf_row"></td>
        <td class="total-perc_row"></td>

        <td class="total-chapeau_row"></td>
        <td class="total-yeux_row"></td>
        <td class="total-main_row"></td>
        <td class="total-pied_row"></td>

        <?php }// end foreach components    ?>
    </tr>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        //iterate through each row in the table
        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum = 0
            var n = 0
            //find the combat elements in the current row and sum it 
            $(this).find('.shelf').each(function () {
                var shelf = $(this).text();
                if (!isNaN(shelf) && shelf.length !== 0) {
                    sum += parseFloat(shelf);
                    n++;
                }
            });
            //set the value of currents rows sum to the total-combat element in the current row
            $('.total-shelf_row', this).html(Math.round(sum));
        });

        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum = 0
            var n = 0
            //find the combat elements in the current row and sum it 
            $(this).find('.perc').each(function () {
                var perc = $(this).text();

                if (!isNaN(perc) && perc.length !== 0) {
                    sum += parseFloat(perc);
                    n++;
                }
            });
            //set the value of currents rows sum to the total-combat element in the current row
            $('.total-perc_row', this).html(parseFloat(sum / n).toFixed(2));
        });

        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum = 0
            var n = 0
            //find the combat elements in the current row and sum it
            $(this).find('.chapeau').each(function () {
                var chapeau = $(this).text();

                if (!isNaN(chapeau) && chapeau.length !== 0) {
                    sum += parseFloat(chapeau);
                    n++;
                }
            });
            //set the value of currents rows sum to the total-combat element in the current row
            $('.total-chapeau_row', this).html(parseFloat(sum / n).toFixed(2));
        });

        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum = 0
            var n = 0
            //find the combat elements in the current row and sum it
            $(this).find('.yeux').each(function () {
                var yeux = $(this).text();

                if (!isNaN(yeux) && yeux.length !== 0) {
                    sum += parseFloat(yeux);
                    n++;
                }
            });
            //set the value of currents rows sum to the total-combat element in the current row
            $('.total-yeux_row', this).html(parseFloat(sum / n).toFixed(2));
        });

        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum = 0
            var n = 0
            //find the combat elements in the current row and sum it
            $(this).find('.main').each(function () {
                var main = $(this).text();

                if (!isNaN(main) && main.length !== 0) {
                    sum += parseFloat(main);
                    n++;
                }
            });
            //set the value of currents rows sum to the total-combat element in the current row
            $('.total-main_row', this).html(parseFloat(sum / n).toFixed(2));
        });

        $('tr').each(function () {
            //the value of sum needs to be reset for each row, so it has to be set inside the row loop
            var sum = 0
            var n = 0
            //find the combat elements in the current row and sum it
            $(this).find('.pied').each(function () {
                var pied = $(this).text();

                if (!isNaN(pied) && pied.length !== 0) {
                    sum += parseFloat(pied);
                    n++;
                }
            });
            //set the value of currents rows sum to the total-combat element in the current row
            $('.total-pied_row', this).html(parseFloat(sum / n).toFixed(2));
        });
    });
</script>




