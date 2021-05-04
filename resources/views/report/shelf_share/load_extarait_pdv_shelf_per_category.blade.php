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
                                    <th class ="text-center" colspan="3"><?php echo ($outlet_name); ?></th>
                                <?php } ?>

                            </tr>

                            <tr>

                                <th>Brand</th>
                                <th>Product</th>

                                <?php foreach ($outlets as $outlet_name) { ?>

                                    <th class ="text-center">Shelf</th>
                                    <th class ="text-center">Metrage</th>
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
                                    $product = App\Entities\ProductGroup::find($product_id);
                                    $product_name = $product->name;
                                    $brand_name = $product->brand->name;
                                    ?>

                                    <td><?php echo $brand_name; ?></td>
                                    <td><?php echo $product_name; ?></td>


                                    <?php foreach ($outlets as $outlet_name) { ?>
                                        <td class="shelf">
                                            <?php
                                            if (isset($componentOutlets[$outlet_name])) {


                                                echo $componentOutlets[$outlet_name][0];
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                        <td class="metrage">
                                            <?php
                                            if (isset($componentOutlets[$outlet_name])) {


                                                echo number_format($componentOutlets[$outlet_name][1], 3);
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                        <td class="perc">
                                            <?php
                                            if (isset($componentOutlets[$outlet_name][1]) && $sum_metrage[$outlet_name] != 0) {


                                                echo number_format($componentOutlets[$outlet_name][1] * 100 / $sum_metrage[$outlet_name], 2, '.', ' ');
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>



                                    <?php } // end foreach outlet_names   ?>




                                <?php }// end foreach components   ?>


                            </tr>
                            <tr>
                                <td align="center">Total</td>
                                <?php foreach ($outlets as $outlet_name) { ?>
                                    <td class="totalshelf" id="sum1"></td>
                                    <td class="totalmetrage" id="sum3"></td>
                                    <td class="totalperc" id="sum2"></td>
                                <?php } // end foreach zones    ?>

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

<script>

    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumshelfzone = 0;
                column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumshelfzone += parseFloat($('td.shelf:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumshelfzone.toFixed(2));
            });
        }
        tally('td.totalshelf');
    });

</script>

<script>

    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumshelfzone = 0;
                column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumshelfzone += parseFloat($('td.metrage:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumshelfzone.toFixed(2));
            });
        }
        tally('td.totalmetrage');
    });

</script>


<script>

    $(function () {
        function tally(selector) {
            $(selector).each(function () {
                var sumshelfzone = 0;
                column = $(this).siblings(selector).addBack().index(this);
                $(this).parents().prevUntil(':has(' + selector + ')').each(function () {
                    sumshelfzone += parseFloat($('td.perc:eq(' + column + ')', this).html()) || 0;
                })
                $(this).html(sumshelfzone.toFixed(2));
            });
        }
        tally('td.totalperc');
    });

</script>