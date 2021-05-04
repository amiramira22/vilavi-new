
<div class="m-section__content">
    <table class="table m-table m-table--head-bg-danger">
        <thead>
            <tr>
                <th style=" width: 90px !important;">#</th>
                <th style=" width: 1250px !important;">Product</th>
                <th style=" width: 90px !important;">Oos %</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($prod_this_week as $p) {
                ?>
                <tr>
                    <th scope="row" style=" width: 90px !important;">  {{$i}}</th>
                    <td style=" width: 125px !important;"><?php echo $p['product_name']; ?></td>
                    <td style=" width: 90px !important;"><?php echo number_format(($p['oos']), 2); ?></td>
                </tr>

                <?php
                $i++;
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td><b><a class="m--font-red" href="<?php echo url('dashboard/top_oos_all_products/' . $date); ?>" target="_blank">view all</a></b></td>
            </tr>
        </tbody>
    </table>
</div>