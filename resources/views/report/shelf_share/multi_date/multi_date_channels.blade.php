
<?php
if (!empty($selected_channel_ids)) {
    $i = 0;
    foreach ($selected_channel_ids as $channel_id) {
        $out_val = $i++;
        //dd($channel_id);
        if ($channel_id != -1) {
            $channel = App\Entities\Channel::find($channel_id);
            $channel_name = $channel->name;
            ?> 
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                                <?php echo $channel_name; ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin::Section-->
                    <div class="m-section">
                        <div class="m-section__content" id="channel_div<?php echo $out_val; ?>">


                            <script type="text/javascript">

                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                $('#channel_div<?php echo $out_val; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                                jQuery.ajax({
                                    type: 'post',
                                    url: '<?= route('report.load_shelf_channel') ?>',
                                    data: {_token: CSRF_TOKEN,
                                        start_date: "<?php echo $start_date; ?>",
                                        end_date: "<?php echo $end_date; ?>",
                                        date_type: "<?php echo $date_type; ?>",
                                        multi_date: "<?php echo $multi_date; ?>",
                                        category_id: "<?php echo $category_id; ?>",
                                        channel_id: "<?php echo $channel_id; ?>",
                                        zone_id: "-1",
                                        channel_val: "<?php echo $channel_id; ?>",
                                        out_val: "0"
                                    },

                                    success: function (data) {
                                        $('#channel_div<?php echo $out_val; ?>').html(data);
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>