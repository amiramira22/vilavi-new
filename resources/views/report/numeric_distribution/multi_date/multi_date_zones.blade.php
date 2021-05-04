
<?php
if (!empty($selected_zone_ids)) {
    foreach ($selected_zone_ids as $zone_id) {
        //dd($zone_id);
        $zone = App\Entities\Zone::find($zone_id);
        $zone_name = $zone->name;
        ?> 
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                            <?php echo $zone_name; ?>
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content" id="zone_div<?php echo $zone_id; ?>-1">
                        <script type="text/javascript">
                            var channel_ids = JSON.stringify(<?php echo $json_channel_ids; ?>);
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $('#zone_div<?php echo $zone_id; ?>-1').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                            jQuery.ajax({
                                type: 'post',
                                url: '<?= route('report.load_av_zone') ?>',
                                data: {_token: CSRF_TOKEN,
                                    start_date: "<?php echo $start_date; ?>",
                                    end_date: "<?php echo $end_date; ?>",
                                    multi_date: "<?php echo $multi_date; ?>",
                                    category_id: "<?php echo $category_id; ?>",
                                    zone_id: "<?php echo $zone_id; ?>",
                                    zone_val: "<?php echo $zone_id; ?>",
                                    json_channel_ids: channel_ids,
                                    out_val: "0",
                                    date_type: "<?php echo $date_type; ?>"
                                },

                                success: function (data) {
                                    $('#zone_div<?php echo $zone_id; ?>-1').html(data);
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
?>