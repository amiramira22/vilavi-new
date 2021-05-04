

<div class="content_data" id="content_data_<?php echo $categories->first()->id; ?>">
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                        <?php echo $categories->first()->name; ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin::Section-->
            <div class="m-section">


                <!--START DYNAMIC DATA-->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <?php foreach ($product_ids as $product_id) {?>
                            <th class="text-center">
                                {{App\Entities\Product::find($product_id)->name}}
                            </th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th>Outlet</th>
                            <?php foreach ($product_ids as $product_id) { ?>
                            <th class="text-center"> AV%</th>
                            <?php } ?>
                        </tr>
                        <thead>
                        <tbody>

                        <?php
                        $i = 0;
                        $sum_products = array();
                        foreach ($components as $outlet_id => $componentPds) {
                        $i++;
                        ?>
                        <tr>
                            <td>{{ App\Entities\Outlet::find($outlet_id)->name  }}</td>
                            <?php foreach ($product_ids as $product_id) { ?>
                            <td clas="col-md-1">
                                <?php
                                if (isset($componentPds[$product_id])) {
                                    if (($componentPds[$product_id][1] != 0) && ($componentPds[$product_id][0] == 0) && ($componentPds[$product_id][3] == 0)) {
                                        echo '<p style="color:blue">HA</p>';
                                    } else {
                                        //echo number_format($componentOutlets[$outlet_name][0], 2, '.', ' ');
                                        $perc = number_format(($componentPds[$product_id][3] / ($componentPds[$product_id][0] + $componentPds[$product_id][3])) * 100, 2, '.', ' ');
                                        if (isset($sum_products[$product_id])) {
                                            $sum_products[$product_id] = $sum_products[$product_id] + $perc;
                                        } else {
                                            $sum_products[$product_id] = $perc;
                                        }

                                        if ($perc == '0.00') {
                                            echo '<p style="color:red">';
                                        } else {
                                            echo '<p style="color:black">';
                                        }
                                        echo $perc . '</p>';
                                    }
                                } else
                                    echo '-';
                                ?>

                            </td>

                            <?php } // end foreach outlet_names   ?>
                            <?php }// end foreach components   ?>
                        </tr>
                        <tr>
                            <td><b>Overage</b></td>
                            <?php foreach ($product_ids as $product_id) { ?>

                            <td clas="col-md-1">
                                <?php
                                if ($i != 0 && (isset($sum_products[$product_id]))) {
                                    echo number_format($sum_products[$product_id] / $i, 2, '.', ' ');
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <?php } // end foreach $product_id   ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--END DYNAMIC DATA-->
            </div>
        </div>
    </div>
</div>


<div class="load-more" lastID="<?php echo $categories->first()->id; ?>" style="display: none;">
    <div class="col-md-12" align="center">
        <img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center"/>
    </div>
</div>