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
    $components[$row['product_group_id']][$zone] = [
        $row['shelf']
        , $row['brand_name']
        , $row['chapeau']
        , $row['yeux']
        , $row['main']
        , $row['pied']

    ];
    $components_zone [$row['zone']][$row['product_group_id']] = $row['shelf'];
}// end foreach report_data
?>

<div class="table-responsive">
  <table class="table table-bordered table-hover" id="myTable<?php echo $cluster_id; ?>">

    <thead>
    <tr>
      <th colspan="3"></th>

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
      <th>Rank</th>
      <th>Brand</th>
      <th>Product</th>

        <?php foreach ($zones as $zone) { ?>
          <th>shelf</th>
          <th>%</th>
          <th>Niveau chapeau</th>
          <th>Niveau des yeux</th>
          <th>Niveau des mains</th>
          <th>Niveau des pieds</th>
        <?php } ?>
      <th>shelf</th>
      <th>%</th>
      <th>Niveau chapeau</th>
      <th>Niveau des yeux</th>
      <th>Niveau des mains</th>
      <th>Niveau des pieds</th>
    </tr>

    </thead>

    <tbody>

    <?php
    $i = 0;
    foreach ($components

    as $product_group_id => $componentZones) {
    $i++;
    ?>
    <tr>
        <?php
        $product_group = App\Entities\ProductGroup::find($product_group_id);
        $product_group_name = $product_group->name;
        //$brand_name = $product_group->brand->name;
        ?>
      <td class="rank<?php echo $cluster_id; ?>"><b><?php echo $i; ?></b></td>

      <td><?php echo $componentZones[$zone][1]; ?></td>

      <td><?php echo $product_group->name; ?></td>

        <?php foreach ($zones as $zone) { ?>
          <td class="shelf_brand<?php echo $cluster_id; ?>">
              <?php
              if (isset($componentZones[$zone])) {
                  echo $componentZones[$zone][0];
              } else
                  echo '-';
              ?>
          </td>

          <td class="chapeau_brand_num<?php echo $cluster_id; ?>" style="display: none;">
              <?php
              if (isset($componentZones[$zone])) {
                  echo $componentZones[$zone][2];
              } else
                  echo '-';
              ?>
          </td>
          <td class="yeux_brand_num<?php echo $cluster_id; ?>" style="display: none;">
              <?php
              if (isset($componentZones[$zone])) {
                  echo $componentZones[$zone][3];
              } else
                  echo '-';
              ?>
          </td>
          <td class="main_brand_num<?php echo $cluster_id; ?>" style="display: none;">
              <?php
              if (isset($componentZones[$zone])) {
                  echo $componentZones[$zone][4];
              } else
                  echo '-';
              ?>
          </td>
          <td class="pied_brand_num<?php echo $cluster_id; ?>" style="display: none;">
              <?php
              if (isset($componentZones[$zone])) {
                  echo $componentZones[$zone][5];
              } else
                  echo '-';
              ?>
          </td>


          <td class="perc_brand<?php echo $cluster_id; ?>">
              <?php
              if (isset($componentZones[$zone])) {
                  //echo  ($componentDates[$zone][0]/ $sum_shelf_zone[$zone])*100 .'%';
                  if ($sum_shelf_array[$zone] != 0) {
                      echo number_format(($componentZones[$zone][0] / $sum_shelf_array[$zone]) * 100, 2);
                  } else {
                      echo '0';
                  }
                  // echo $componentDates[$zone][0];
              } else
                  echo '-';
              ?>
          </td>
          <td class="chapeau_brand<?php echo $cluster_id; ?>">
              <?php
              if (isset($componentZones[$zone])) {
                  //echo  ($componentDates[$zone][0]/ $sum_shelf_zone[$zone])*100 .'%';
                  if ($sum_chapeau_array[$zone] != 0) {
                      echo number_format(($componentZones[$zone][2] / $sum_chapeau_array[$zone]) * 100, 2);
                  } else {
                      echo '0';
                  }
                  // echo $componentDates[$zone][0];
              } else
                  echo '-';
              ?>
          </td>

          <td class="yeux_brand<?php echo $cluster_id; ?>">
              <?php
              if (isset($componentZones[$zone])) {
                  //echo  ($componentDates[$zone][0]/ $sum_shelf_zone[$zone])*100 .'%';
                  if ($sum_yeux_array[$zone] != 0) {
                      echo number_format(($componentZones[$zone][3] / $sum_yeux_array[$zone]) * 100, 2);
                  } else {
                      echo '0';
                  }
                  // echo $componentDates[$zone][0];
              } else
                  echo '-';
              ?>
          </td>

          <td class="main_brand<?php echo $cluster_id; ?>">
              <?php
              if (isset($componentZones[$zone])) {
                  //echo  ($componentDates[$zone][0]/ $sum_shelf_zone[$zone])*100 .'%';
                  if ($sum_main_array[$zone] != 0) {
                      echo number_format(($componentZones[$zone][4] / $sum_main_array[$zone]) * 100, 2);
                  } else {
                      echo '0';
                  }
                  // echo $componentDates[$zone][0];
              } else
                  echo '-';
              ?>
          </td>

          <td class="pied_brand<?php echo $cluster_id; ?>">
              <?php
              if (isset($componentZones[$zone])) {
                  //echo  ($componentDates[$zone][0]/ $sum_shelf_zone[$zone])*100 .'%';
                  if ($sum_pied_array[$zone] != 0) {
                      echo number_format(($componentZones[$zone][5] / $sum_pied_array[$zone]) * 100, 2);
                  } else {
                      echo '0';
                  }
                  // echo $componentDates[$zone][0];
              } else
                  echo '-';
              ?>
          </td>




        <?php } // end foreach zones   ?>

      <td class="total-shelf_brand<?php echo $cluster_id; ?>"></td>
      <td class="total-perc_brand<?php echo $cluster_id; ?>"></td>

      <td class="total-chapeau_brand<?php echo $cluster_id; ?>"></td>
      <td class="total-yeux_brand<?php echo $cluster_id; ?>"></td>
      <td class="total-main_brand<?php echo $cluster_id; ?>"></td>
      <td class="total-pied_brand<?php echo $cluster_id; ?>"></td>

        <?php }// end foreach components    ?>
    </tr>
    </tbody>
  </table>
</div>


<script>
    $(document).ready(function () {

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
            $(this).find('.shelf_brand<?php echo $cluster_id; ?>').each(function () {
                var shelf = $(this).text();
                var shelf = shelf.replace(",", "");
                if (!isNaN(shelf) && shelf.length !== 0 && shelf > 0) {
                    sum_shelf += parseFloat(shelf);
                }
            });

            $(this).find('.chapeau_brand_num<?php echo $cluster_id; ?>').each(function () {
                console.log('chapeau_brand_num');
                var chapeau = $(this).text();
                var chapeau = chapeau.replace(",", "");
                if (!isNaN(chapeau) && chapeau.length !== 0 && chapeau > 0) {
                    sum_chapeau += parseFloat(chapeau);
                }
            });

            $(this).find('.yeux_brand_num<?php echo $cluster_id; ?>').each(function () {
                var yeux = $(this).text();
                var yeux = yeux.replace(",", "");
                if (!isNaN(yeux) && yeux.length !== 0 && yeux > 0) {
                    sum_yeux += parseFloat(yeux);
                }
            });


            $(this).find('.main_brand_num<?php echo $cluster_id; ?>').each(function () {
                var main = $(this).text();
                var main = main.replace(",", "");
                if (!isNaN(main) && main.length !== 0 && main > 0) {
                    sum_main += parseFloat(main);
                }
            });

            $(this).find('.pied_brand_num<?php echo $cluster_id; ?>').each(function () {
                var pied = $(this).text();
                var pied = pied.replace(",", "");
                if (!isNaN(pied) && pied.length !== 0 && pied > 0) {
                    sum_pied += parseFloat(pied);
                }
            });

            $('.total-shelf_brand<?php echo $cluster_id; ?>', this).html(parseFloat(sum_shelf).toFixed(0));
            $('.total-perc_brand<?php echo $cluster_id; ?>', this).html(parseFloat((sum_shelf / tot_shelf) * 100).toFixed(2));

            $('.total-chapeau_brand<?php echo $cluster_id; ?>', this).html(parseFloat((sum_chapeau / tot_chapeau) * 100).toFixed(2));
            $('.total-yeux_brand<?php echo $cluster_id; ?>', this).html(parseFloat((sum_yeux / tot_yeux) * 100).toFixed(2));
            $('.total-main_brand<?php echo $cluster_id; ?>', this).html(parseFloat((sum_main / tot_main) * 100).toFixed(2));
            $('.total-pied_brand<?php echo $cluster_id; ?>', this).html(parseFloat((sum_pied / tot_pied) * 100).toFixed(2));


        });// end foreach TR

    });
</script>

<script>
    //$(document).ready(function () {

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


    //});
</script>