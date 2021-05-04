
@extends('layouts.admin.template')
@section('content')
<div class="m-portlet m-portlet--tabs">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-line-graph m--font-danger"></i>
                </span>

                <h3 class="m-portlet__head-text m--font-danger">
                    {{$visit->outlet->name}} | <?php echo reverse_format($visit->date); ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">

        <div class="row">



            <div class="col-md-12">
                <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                    <div class="tab-content">

                        <?php
                        if (($visit->order_picture != '') && ($visit->order_picture != '[]')) {
                        $orders = $visit->order_picture;
                        $orders = json_decode($orders);
                        ?>
                        <?php for ($i = 0; $i < sizeof($orders); $i++) { ?>

                        <img class="zoom" src="{{'https://'.env('project_name').'.cap.tn/uploads/order/' . $orders[$i]}}"
                             id='pic<?php echo $orders[$i]; ?>' alt="admin-pic" download width="400px"
                             height="400px">

                        <?php } ?>
                        <?php } else { ?>
                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+images" alt=""
                             id="def5" width="100%" style="height:350px" ;>

                        <?php } ?>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


