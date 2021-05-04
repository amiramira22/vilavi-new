@extends('layouts.admin.template')

@section('content')
<style>
    .m-body .m-content {
        padding: 10px 0px !important;
    }
    .m-subheader {
        padding: 30px 0px 0 0px !important;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src="{{ asset('assets/excel_jquery/src/jquery.table2excel.js') }}"></script>




<?php
//    //print_r($row);
//    echo $row->product_name;
//    echo '<br>';
//    echo $row->outlet_name;
//    echo '<br>';
//    echo $row->date;
//    echo '<br>';
//    echo '<br>';
//print_r($nb_oos_tracking);
$outlets = array();
$components = array();

foreach ($report_data as $row) {

    $outlet = $row->outlet_name;

    if (!in_array($outlet, $outlets)) {
        $outlets[] = $outlet;
    }
    //create an array for every brand and the count at a outlet
    $components[$row->product_name][$outlet] = array($row->date, $row->nb_oos);
}
//print_r($components);
?>
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">

                    @lang('project.STOCK_ISSUE')
                </h3>
            </div>
        </div>

        <div class="m-portlet__head-tools">
            <button class="btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand" id="button_excel">Export EXCEL</button>
        </div>

    </div>
    <div class="m-portlet__body">
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table2excel">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <?php foreach ($outlets as $out) { ?>
                                    <th><?php echo $out; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($components as $product_name => $componentDates) { ?>
                                <tr>

                                    <?php
                                    //$product = $this->Product_model->get_product($product_id);
                                    ?>
                                    <td><?php echo $product_name; ?></td>

                                    <?php foreach ($outlets as $out) { ?>
                                        <td>
                                            <?php
                                            if (isset($componentDates[$out]) && ($componentDates[$out][1] >= 3)) {
                                                //$av_j_1 = $this->Report_model->get_av_j(24, 101, $componentDates[$out][0], 1);
                                                //$av_j_2 = $this->Report_model->get_av_j($product_name, $out, $componentDates[$out], 2);
                                                //if ($av_j_1 == 0 and $av_j_2 == 0)
                                                //echo 'num_rows'.$av_j_1;
                                                echo reverse_format($componentDates[$out][0]);
                                                echo '<br>';
                                                echo '(' . $componentDates[$out][1] . ')';
                                            } else
                                                echo '-';
                                            ?> 
                                        </td>

                                    <?php } // end foreach dates    ?>
                                <?php }// end foreach components  ?>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
var d = new Date();
var date = d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
//var day = d.getDate();
$("button").click(function () {
    $("#table2excel").table2excel({

        name: "Worksheet Name",
        filename: "BVM_OOS TRACKING_" + date //do not include extension
    });
}
);
</script>

@endsection
