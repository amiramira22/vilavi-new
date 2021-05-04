@extends('layouts.admin.template')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">

        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-list-3 m--font-danger"></i>
                </span>
                <h3 class="m-portlet__head-text m--font-danger">
                    @if(isset($subTitle)) {{ $subTitle }}  @endif
                </h3>
            </div>			
        </div>

    </div>
    <div class="m-portlet__body">
        <!--begin: Datatable -->
        <div class="table-responsive">
            <table class="table table-striped- table-bordered table-hover table-checkable"  id="">
                <thead>

                    <tr>	
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Product.Group</th>
                        <th>Custering</th>
                        <th>Sub.category</th>
                        <th>Category</th>
                        <th>HA</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr class="odd gradeX">
                            <td><?php echo $product->id; ?></td>
                            <td><?php echo $product->product_code; ?></td>
                            <td><?php echo $product->product_name; ?></td>
                            <td><?php echo $product->brand_name; ?></td>
                            <td><?php echo $product->product_group_name; ?></td>
                            <td><?php echo $product->cluster_name; ?></td>
                            <td><?php echo $product->sub_category_name; ?></td>
                            <td><?php echo $product->category_name; ?></td>

                            <td>
                                <div  id="status<?php echo $product->id; ?>" style="display: inline">
                                    <?php if (!in_array($product->id, $ha_product_ids)) { ?>

                                        <a onclick=" enable('<?php echo $product->id; ?>', '<?php echo $outlet_id; ?>')" class="btn m-btn--pill    btn-secondary btn-sm m-btn m-btn--custom m-btn--label-accent"  data-toggle="tooltip" data-placement="top" title="Disable"> <i class="fa fa-thumbs-down m--font-danger"></i> </a>	
                                    <?php } else { ?>
                                        <a onclick=" disable('<?php echo $product->id; ?>', '<?php echo $outlet_id; ?>')" class="btn m-btn--pill    btn-secondary btn-sm m-btn m-btn--custom m-btn--label-accent"  data-toggle="tooltip" data-placement="top" title="Enable">  <i class="fa fa-thumbs-up m--font-primary"></i> </a>		
                                    <?php } ?>
                                </div>


                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function enable(product_id, outlet_id) {

        $.ajax({

            url: '<?= route('admin.product.enable') ?>',
            type: "POST",
            data: {_token: CSRF_TOKEN, product_id: product_id, outlet_id: outlet_id},
            success: function (data) {
                console.log(data);
                $('#status' + product_id).html(data);
            }
        });
    }
    function disable(product_id, outlet_id) {


        $.ajax({

            url: '<?= route('admin.product.disable') ?>',
            type: "POST",
            data: {_token: CSRF_TOKEN, product_id: product_id, outlet_id: outlet_id},
            success: function (data) {
                console.log(data);
                $('#status' + product_id).html(data);
            }
        });
    }
</script>
@endsection