<style>
    .m-tabs-line .m-tabs__item {
        margin-right: 6px;
        margin-bottom: -1px;
    }
</style>

<div class="m-portlet m-portlet--tabs" style="height:389px">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text {{env('iconColor')}}">
                    <i class="flaticon-pie-chart {{env('iconColor')}}"></i>
                    <span style="padding-left:10px;"></span>
                    TOP 5 OOS
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <style>
                /*                .m-table.m-table--head-bg-brand thead th {
                                    background: #6794DC;
                                }*/
            </style>
            <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--right m-tabs-line--danger" role="tablist">

                <!--begin::week 1-->
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active" 
                       href="#<?php echo 'tab4_' . $date_this_week; ?>" 
                       id="<?php echo 'top_' . $date_this_week; ?>" 
                       data-toggle="tab"
                       role="tab"> 
                           <?php echo format_week($date_this_week); ?> 
                    </a>
                </li>
                <script type="text/javascript">

                    $("#<?php echo 'top_' . $date_this_week; ?>").click(function () {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $('#content_top_oos_products<?php echo '_' . $date_this_week; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');

                        jQuery.ajax({

                            url: '<?= route('admin.dashboard.load_top_oos_products') ?>',
                            data: {_token: CSRF_TOKEN, date: "<?php echo $date_this_week; ?>"},
                            type: "POST",
                            success: function (data) {
                                $('#content_top_oos_products<?php echo '_' . $date_this_week; ?>').html(data);
                            }
                        });

                    });

                </script>
                <!--end::week 1-->

                <!--begin::week 2-->
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" 
                       href="#<?php echo 'tab4_' . $date_last_week; ?>" 
                       id="<?php echo 'top_' . $date_last_week; ?>" 
                       data-toggle="tab"
                       role="tab"> 
                           <?php echo format_week($date_last_week); ?> 
                    </a>
                </li>
                <script type="text/javascript">

                    $("#<?php echo 'top_' . $date_last_week; ?>").click(function () {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $('#content_top_oos_products<?php echo '_' . $date_last_week; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');

                        $.ajax(
                                {
                                    url: '<?= route('admin.dashboard.load_top_oos_products') ?>',
                                    data: {_token: CSRF_TOKEN, date: "<?php echo $date_last_week; ?>"},
                                    type: 'POST',
                                }).done(
                                function (data)
                                {
                                    $('#content_top_oos_products<?php echo '_' . $date_last_week; ?>').html(data);
                                }
                        );

                    });

                </script>
                <!--end::week 2-->

                <!--begin::week 3-->
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" 
                       href="#<?php echo 'tab4_' . $date_last2_week; ?>" 
                       id="<?php echo 'top_' . $date_last2_week; ?>" 
                       data-toggle="tab"
                       role="tab"> 
                           <?php echo format_week($date_last2_week); ?> 
                    </a>
                </li>
                <script type="text/javascript">

                    $("#<?php echo 'top_' . $date_last2_week; ?>").click(function () {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $('#content_top_oos_products<?php echo '_' . $date_last2_week; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');

                        $.ajax(
                                {
                                    url: '<?= route('admin.dashboard.load_top_oos_products') ?>',
                                    data: {_token: CSRF_TOKEN, date: "<?php echo $date_last2_week; ?>"},
                                    type: 'POST',
                                }).done(
                                function (data)
                                {
                                    $('#content_top_oos_products<?php echo '_' . $date_last2_week; ?>').html(data);
                                }
                        );
                    });



                </script>
                <!--end::week 3-->


                <!--begin::week 4-->
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" 
                       href="#<?php echo 'tab4_' . $date_last3_week; ?>" 
                       id="<?php echo 'top_' . $date_last3_week; ?>" 
                       data-toggle="tab"
                       role="tab"> 
                           <?php echo format_week($date_last3_week); ?> 
                    </a>
                </li>
                <script type="text/javascript">

                    $("#<?php echo 'top_' . $date_last3_week; ?>").click(function () {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $('#content_top_oos_products<?php echo '_' . $date_last3_week; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');

                        $.ajax(
                                {
                                    url: '<?= route('admin.dashboard.load_top_oos_products') ?>',
                                    data: {_token: CSRF_TOKEN, date: "<?php echo $date_last3_week; ?>"},
                                    type: 'POST',
                                }).done(
                                function (data)
                                {
                                    $('#content_top_oos_products<?php echo '_' . $date_last3_week; ?>').html(data);
                                }
                        );

                    });

                </script>
                <!--end::week 4-->


            </ul>
        </div>
    </div>

    <!--    {{ $prod_this_week }}-->
    <div class="m-portlet__body">
        <div class="tab-content">

            <div class="tab-pane active" id="<?php echo 'tab4_' . $date_this_week; ?>">
                <div id="content_top_oos_products<?php echo '_' . $date_this_week; ?>">
<!--                    <style>
                        .m-table.m-table--head-bg-brand thead th {
                            background: #6e7cca;

                        }

                    </style>-->
                    <table class="table m-table m-table--head-bg-{{env('tableColor')}}">
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
                                    <th scope="row" style=" width: 90px !important;">{{$i}}</th>
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
                                <td><b><a class="m--font-red" href="<?php echo url('admin/dashboard/top_oos_all_products/' . $date_this_week); ?>" target="_blank">view all</a></b></td>
                            </tr> 
                        </tbody>
                    </table>

                </div>
            </div>


            <div  class="tab-pane " id="<?php echo 'tab4_' . $date_last_week; ?>">
                <div id="content_top_oos_products<?php echo '_' . $date_last_week; ?>">

                </div>
            </div>

            <div  class="tab-pane " id="<?php echo 'tab4_' . $date_last2_week; ?>">
                <div id="content_top_oos_products<?php echo '_' . $date_last2_week; ?>">

                </div>
            </div>

            <div  class="tab-pane " id="<?php echo 'tab4_' . $date_last3_week; ?>">
                <div id="content_top_oos_products<?php echo '_' . $date_last3_week; ?>">

                </div>
            </div>
        </div>
    </div>
</div>

