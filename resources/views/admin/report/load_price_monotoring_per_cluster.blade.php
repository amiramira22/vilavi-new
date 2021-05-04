<div class="table-responsive">
    <table class="table table-bordered table-hover">


        <thead>
            <tr>
                <th colspan="2"> </th>
                <?php foreach ($outlets as $outlet_name) { ?>
                    <th colspan="2"><?php echo $outlet_name; ?></th>
                <?php } ?>
            </tr>
            <tr>
                <th> Brand</th>
                <th>Product </th>
                <?php foreach ($outlets as $outlet_name) { ?>
                    <th> Price</th>
                    <th> Promo Price</th>
                <?php } ?>
            </tr>

        </thead>
        <tbody>
            <?php foreach ($components as $product_id => $componentOutlets) { ?>
                <?php
                $product = App\Entities\Product::find($product_id);
                $product_name = $product->name;
                $brand_name = $product->brand->name;
                ?>
                <tr>
                    <td><?php echo $brand_name; ?></td>
                    <td><?php echo $product->name; ?></td>
                    <?php foreach ($outlets as $outlet) { ?>
                        <td>
                            <?php
                            if (isset($componentOutlets[$outlet][0])) {
                                if ($componentOutlets[$outlet][0] != 0)
                                    echo number_format($componentOutlets[$outlet][0], 3, '.', ' ');
                                else
                                    echo $componentOutlets[$outlet][0];
                            } else
                                echo '-';
                            ?>
                        </td>
                        <td>
                            <?php
                            if (isset($componentOutlets[$outlet][1])) {
                                if ($componentOutlets[$outlet][1] != 0)
                                    echo number_format($componentOutlets[$outlet][1], 3, '.', ' ');
                                else 
                                    echo $componentOutlets[$outlet][1];
                            } else
                                echo '-';
                            ?>

                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>



        </tbody>
    </table>
</table>
</div>