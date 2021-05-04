<div class="content_data" id="content_data_<?php echo $categories->first()->id; ?>" > 
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
                                        <th colspan="2"></th>
                                        <?php foreach ($outlets as $outlet_name) { ?>
                                            <th class ="text-center" colspan="2"><?php echo ($outlet_name); ?></th>
                                        <?php } ?>

                                    </tr>

                                    <tr>
                                        <th>Brand</th>
                                        <th>Product</th>
                                        <?php foreach ($outlets as $outlet_name) { ?>

                                            <th class ="text-center">Shelf</th>
                                            <th class ="text-center">%</th>
                                        <?php } ?>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php
                                    $i = 0;
                                    foreach ($components as $product_id => $componentOutlets) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <?php
                                            $product = App\Entities\Product::find($product_id);
                                            $product_name = $product->name;
                                            $brand_name = $product->brand->name;
                                            ?>

                                            <td><?php echo $brand_name; ?></td>
                                            <td><?php echo $product->name; ?></td>

                                            <?php foreach ($outlets as $outlet_name) { ?>
                                                <td>
                                                    <?php
                                                    if (isset($componentOutlets[$outlet_name])) {
                                                        echo $componentOutlets[$outlet_name][0];
                                                    } else
                                                        echo '-';
                                                    ?> 
                                                </td>

                                                <td>
                                                    <?php
                                                    if (isset($componentOutlets[$outlet_name][0]) && $componentOutlets[$outlet_name][0] != 0 && $sum_shelf_outlet[$outlet_name] != 0) {
                                                        echo number_format(($componentOutlets[$outlet_name][0] / $sum_shelf_outlet[$outlet_name]) * 100, 2, '.', ' ');
                                                        //echo number_format(($componentDates[$outlet_name][0] / $sum_shelf_outlet[$outlet_name]) * 100, 2, '.', ' ');
                                                    } else
                                                        echo '-';
                                                    ?> 
                                                </td>
                                            <?php } // end foreach outlet_names   ?>
                                        <?php }// end foreach components  ?>
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
        <img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" />
    </div>
</div>