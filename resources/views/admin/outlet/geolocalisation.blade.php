

@extends('layouts.admin.template')
@section('content')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHuB62hGNykVD6L2axjCwu0KUPSBF1VBA&sensor=false"></script>
<script src="{{ asset('assets/js/jquery.gomap-1.3.3.min.js') }}"></script>

<meta name="csrf-token" content="{{ csrf_token() }}" />




<!--<style>

    .chartclass {
        width: 100%;
        height: 100%;
    }	
</style>-->


<style>
    .width-150px{
        width: 80px;
        display: inline-block;
    }

    .my_content{
        height: 700px !important;
    }
    .my_body {
        width: 100%;
        height: 100%;
    }
    .chartclass {
        width: 100%;
        height: 100%;
    }
    .btn-outline-dark{
        color: #000000;
    }
    .m-demo .m-demo__preview {
        background: white;
        border: 2px solid #f7f7fa;
        padding: 0px;
        padding-top: 10px;
    }
</style>

<div class="col-lg-12">
    <div class="m-portlet">

        <div class="m-portlet__body">

            <div class="m-section">
                <div class="m-section__content">
                    <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                        <div class="m-demo__preview m-demo__preview--btn">
                            <center>
                                <button type="button" class="btn m-btn--pill m-btn--air  btn-sm m-btn m-btn--custom btn-outline-metal " id="all">@lang('project.Show_All_Outlet_Type')</button>
                                <span style="padding-left:10px;"></span>


                                <?php foreach ($channels as $ch) { ?>
                                    <button type="button" class="btn m-btn--pill m-btn--air  btn-sm m-btn m-btn--custom btn-outline-<?php echo $ch->template_color ?>" id="g<?php echo $ch->id ?>"><?php echo $ch->name ?></button>
                                    <span style="padding-left:10px;"></span>
                                <?php } ?>

                                <button type="button" class="btn m-btn--pill m-btn--air  btn-sm m-btn m-btn--custom btn-outline-dark width-150px" id="g0">Inactive</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>


            <!--begin::Section-->
            <div class="m-section my_content">
                <div class="my_body" id="my_chartdiv">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

$("#my_chartdiv").goMap({
latitude: 35.0534864,
        longitude: 9.2408933,
        zoom: 7.2,
        scaleControl: true,
        maptype: 'ROADMAP'
        });
$.goMap.ready(function () {

<?php foreach ($outlets as $outlet) { ?>
    var channel_id = <?php echo $outlet->channel_id; ?>;
    var outlet_active = <?php echo $outlet->active; ?>;
    var lt = <?php echo $outlet->latitude; ?>;
    var lg = <?php echo $outlet->longitude; ?>;
    var outlet_name = "<?php echo $outlet->name; ?>";
    var outlet_zone = "<?php echo $outlet->outletZone->name; ?>";
    var outlet_state = "<?php echo $outlet->outletState->name; ?>";
    var outlet_channel = "<?php echo $outlet->outletChannel->name; ?>";
    var outlet_adress = " <?php echo $outlet->adress; ?>";
    var outlet_id = "<?php echo $outlet->id; ?>";
    var outlet_id = outlet_id.trim();
    console.log("<?php echo $outlet->outletChannel->name; ?>");
    var g = 'g';
    group = g.concat(channel_id);
    icon = "{{ asset('assets/img/'.$outlet->outletChannel->color_name.'1.png') }}";
    if (outlet_active == 0) {
    group = 'g0';
    icon = "{{ asset('assets/img/black1.png') }}";
    }

    //*******************************


    $.goMap.createMarker({
    latitude: lt,
            longitude: lg,
            group: group,
            icon: icon,
            html: {
            content: "<b>Outlet name:</b> " + outlet_name +
                    "</br><b>Zone:</b> " + outlet_zone +
                    "</br><b>State:</b> " + outlet_state +
                    "</br><b>channel:</b> " + outlet_channel +
                    "</br><b>Adress:</b> " + outlet_adress +
                    '</br><b>Show outlet details:</b> <a class="m--font-red red filter-submit margin-bottom" href="/admin/outlet/view/{{$outlet->id}}" data-toggle="tooltip" data-placement="top" title="Outlet details" target="_blank"><i class="fas fa-map-o"></i></a>',
                            //popup: true
                    }

                    });
            hideByClick: true
<?php } ?>

        });
$("button").click(function () {
//alert($(this).attr('id'));
group = $(this).attr('id');
if (group == 'all')
        for (var i in $.goMap.markers) {
$.goMap.showHideMarker($.goMap.markers[i], true);
}
else {
for (var i in $.goMap.markers) {
$.goMap.showHideMarker($.goMap.markers[i], false);
}

$.goMap.showHideMarkerByGroup(group, true);
}
});
$("#count1").click(function () {
$("#my_chartdiv").goMap();
alert($.goMap.getMarkerCount());
});
});

</script> 



@endsection