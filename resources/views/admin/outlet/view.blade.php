@extends('layouts.admin.template')
@section('content')

<style>
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .m-list-timeline .m-list-timeline__items .m-list-timeline__item .m-list-timeline__text {
        color: #2c3d96;
    }
    .m-portlet .m-portlet__body {
        padding: 1rem 1rem;
    }
</style>



<style>
    /*    .m-nav__link-text{
            white-space: nowrap;
        }*/
    .m-demo .m-demo__preview {
        background: white;
        border: 4px solid #ffffff;
        padding: 5px;
    }
    h5{
        margin-bottom: 0rem;
    }
</style>

<div class="row">
    <!--<div class="col-lg-1"></div>-->
    <div class="col-md-3">
        <!--m-portlet--full-height-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <h5 class="m-portlet__head-text m--font-danger">
                        <span class="m-portlet__head-icon m--font-danger">
                            <i class="flaticon-list-3"></i>
                        </span>
                        <span style="padding-left:5px;"></span>
                        @lang('project.Outlet_Details')
                    </h5>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" style="height: 450px; ">
                    <div class="m-demo">
                        <div class="m-demo__preview">
                            <div class="m-list-timeline">
                                <div class="m-list-timeline__items">
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
                                        <span class="m-list-timeline__text">Created : {{reverse_format($created->created_date)}}</span>
                                    </div>

                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                        <span class="m-list-timeline__text">Name : {{$outlet->name}}</span>

                                    </div>
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>
                                        <span class="m-list-timeline__text">Code :{{$outlet->code}}</span>

                                    </div>
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--warning"></span>
                                        <span class="m-list-timeline__text">State : {{$outlet->outletState->name}}</span>

                                    </div>
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--primary"></span>
                                        <span class="m-list-timeline__text">Zone : {{$outlet->outletZone->name}}</span>

                                    </div>
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
                                        <span class="m-list-timeline__text">Sub ch : {{$outlet->outletSubChannel->name}}</span>

                                    </div>
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                        <span class="m-list-timeline__text">Channel : {{$outlet->outletChannel->name}}</span>

                                    </div>
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                        <span class="m-list-timeline__text">Adress : {{$outlet->adress}}</span>

                                    </div>
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>
                                        <span class="m-list-timeline__text">Fo : {{$outlet->outletUser->name}}</span>
                                    </div>
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
                                        <span class="m-list-timeline__text">Deliv day : {{$outlet->delivery_day}}</span>
                                    </div>

                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
                                        <span class="m-list-timeline__text">Contact PDV : {{$outlet->contact_pdv}}</span>
                                    </div>

                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
                                        <span class="m-list-timeline__text">Contact : {{$outlet->contact}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>			
    </div>	

    <?php //print_r($album[0]->toArray()); ?>
    <?php //echo $album[0][0]->outlet_id ?>
    <div class="col-md-9">
        <div class="m-portlet m-portlet--tabs">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--danger m-tabs-line--2x" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_1" role="tab" aria-selected="true">
                                Position
                            </a>
                        </li>

                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_2" role="tab" aria-selected="false">
                                Photo
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="tab-content">
                    <div class="tab-pane active show" id="m_tabs_1" role="tabpanel">
                        <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" style="height: 450px; ">
                            <?php
                            echo $map['js'];
                            echo $map['html'];
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane" id="m_tabs_2" role="tabpanel">
                        <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" style="height: 450px; ">


                            <?php
//                            if (($album[0]->outlet_picture != '') && ($album[0]->outlet_picture != '[]')) {
                            ?>
                            <div id="carouselExampleIndicators<?php echo $album[0]->outlet_id ?>" class="carousel slide" data-ride="carousel">


                                <ol class="carousel-indicators">


                                    <li data-target="#carouselExampleIndicators<?php echo $album[0]->outlet_id ?>" data-slide-to="0" class="active"></li>

                                    <?php
                                    if (($album[0]->one_pictures != '') && ($album[0]->one_pictures != '[]')) {
                                        $one_pictures = json_decode($album[0]->one_pictures, TRUE);
                                        $size_pictures = sizeof($one_pictures);
                                        for ($i = 0; $i < $size_pictures; $i++) {
                                            ?>
                                            <li data-target="#carouselExampleIndicators<?php echo $album[0]->outlet_id ?>" data-slide-to="$i"></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ol>

                                <style>
                                    img {
                                        display: block;
                                        margin-left: auto;
                                        margin-right: auto;
                                    }

                                </style>


                                <div class="carousel-inner">
                                    <div class="carousel-item active">

                                        <center>
                                            <img width="700px" height="350px" src="https://bcm.cap.tn/uploads/outlet/{{$album[0]->outlet_picture}}"  >
                                        </center>

                                    </div>

                                    <?php
                                    if (($album[0]->one_pictures != '') && ($album[0]->one_pictures != '[]')) {
                                        for ($i = 0; $i < $size_pictures; $i++) {
                                            ?>
                                            <div class="carousel-item">
                                                <?php if (file_exists("https://bcm.cap.tn/uploads/branding/" . $one_pictures[$i])) { ?>
                                                    <center>
                                                        <img src="https://bcm.cap.tn/uploads/branding/{{$one_pictures[$i]}}" width="700px" height="350px" alt="admin-pic" download>
                                                    </center>
                                                <?php } else { ?>
                                                    <center>
                                                        <img src="https://bcm.cap.tn/uploads/branding.old/{{$one_pictures[$i]}}" width="400px" height="400px" alt="admin-pic" download>
                                                    </center>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>

                                <a class="carousel-control-prev" href="#carouselExampleIndicators<?php echo $album[0]->outlet_id ?>" role="button" data-slide="prev">
                                    <span class="fa fa-angle-left" style="color:red; font-size:2rem;"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators<?php echo $album[0]->outlet_id ?>" role="button" data-slide="next">
                                    <span class="fa fa-angle-right" style="color:red; font-size:2rem;"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>


                            <?php // } else { ?>
                                <!--<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+images" alt="" id="def5" width="100%" style="height:350px";>-->

                            <?php //} ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection