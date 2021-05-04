@extends('layouts.admin.template')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-search m--font-danger"></i>
                </span>
                    <h3 class="m-portlet__head-text m--font-danger" style="text-transform: uppercase">
                        @lang('project.SEARCH')
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        {!! Form::open(['url' => 'report/store_album', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}

        <style>
            .m-form .m-form__actions {
                padding: 15px;
            }

            .m-form .m-form__group {
                margin-bottom: 10px;
                padding-top: 30px;
                padding-bottom: 30px;

            }

        </style>
        <div class="form-group m-form__group row">


            <label class="col-md-1 col-form-label">Outlets</label>
            <div class="col-md-3">
                {!! Form::select('fo_id', $fos , $fo_id ,['class' => 'form-control m-select2','id'=>'specific_fo']) !!}
            </div>

            <label class="col-md-1 col-form-label">Outlets</label>
            <div class="col-md-3">
                {!! Form::select('zone_id', $zones , $zone_id ,['class' => 'form-control m-select2','id'=>'specific_zone']) !!}
            </div>

            <label class="col-md-1 col-form-label">Outlets</label>
            <div class="col-md-3">
                {!! Form::select('outlet_id', $outlets , null ,['class' => 'form-control m-select2','id'=>'specific_outlet']) !!}
            </div>
        </div>


        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <div class="row">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                        {!! Form::submit('Submit', ['class' => 'btn m-btn--pill m-btn--air btn-outline-danger']) !!}
                        <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <style>
        /*    .m--font-danger{
                color: #2c3d96 !important;
            }*/
        .m-demo .m-demo__preview {
            background: white;
            border: 4px solid #ffffff;
            padding: 30px;
        }
    </style>
    @if($fo_id != -1)
        <!--{{$store_album_report}}-->
        @foreach($store_album_report as $row)

            <div class="row">
                <!--<div class="col-lg-1"></div>-->
                <div class="col-lg-3">
                    <!--m-portlet--full-height-->
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">

                                    <h4 class="m-portlet__head-text m--font-danger">
                            <span class="m-portlet__head-icon m--font-danger">
                                <i class="flaticon-list-3"></i>
                            </span>
                                        <span style="padding-left:5px;"></span>
                                        DETAILS
                                    </h4>


                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <!--begin::Section-->
                            <div class="m-section m-section--last">
                                <div class="m-section__content">
                                    <!--begin::Preview-->
                                    <div class="row">
                                        <div class="m-demo" data-code-preview="true" data-code-html="true"
                                             data-code-js="false">
                                            <div class="m-demo__preview">
                                                <ul class="m-nav">
                                                    <li class="m-nav__item">
                                                        <h6>
                                                            <i class="fas fa-chevron-right m--font-danger"></i>
                                                            <span class="m-nav__link-text">{{$row['fo_name']}}</span>
                                                        </h6>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <h6>
                                                            <i class="fas fa-chevron-right m--font-danger"></i>
                                                            <span class="m-nav__link-text">{{$row['outlet_name']}}</span>
                                                        </h6>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <h6>
                                                            <i class="fas fa-chevron-right m--font-danger"></i>
                                                            <span class="m-nav__link-text">{{$row['zone_name']}}</span>
                                                        </h6>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <h6>
                                                            <i class="fas fa-chevron-right m--font-danger"></i>
                                                            <span class="m-nav__link-text">{{reverse_format($row->date)}}</span>
                                                        </h6>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Preview-->
                                </div>
                            </div>
                            <!--end::Section-->
                        </div>
                    </div>
                </div>


                <div class="col-lg-9">
                    <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                        <div class="tab-content">


                            <?php
                            if (($row->one_pictures != '') && ($row->one_pictures != '[]')) {
                            $one_pictures = json_decode($row->one_pictures, TRUE);
                            ?>
                            <div id="carouselExampleIndicators<?php echo $row->id ?>" class="carousel slide"
                                 data-ride="carousel">


                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators<?php echo $row->id ?>" data-slide-to="0"
                                        class="active"></li>

                                    <?php
                                    $size_pictures = sizeof($one_pictures);
                                    for ($i = 0; $i < $size_pictures; $i++) {
                                    ?>
                                    <li data-target="#carouselExampleIndicators<?php echo $row->id ?>"
                                        data-slide-to="$i"></li>
                                    <?php } ?>
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
                                            <img src=" {{ asset('outlet/'.  $row->outlet_picture) }}" alt="admin-pic"
                                                 download width="800px" height="400px">
                                        </center>

                                    </div>

                                    <?php
                                    for ($i = 0; $i < $size_pictures; $i++) {
                                    ?>
                                    <div class="carousel-item">
                                        <center>
                                            <img src="{{ asset('branding/'. $one_pictures[$i])}}" width="700px"
                                                 height="350px" alt="admin-pic" download>
                                        </center>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <a class="carousel-control-prev" href="#carouselExampleIndicators<?php echo $row->id ?>"
                                   role="button" data-slide="prev">
                                    <!--<span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
                                    <span class="fa fa-angle-left" style="color:red; font-size:2rem;"></span>

                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators<?php echo $row->id ?>"
                                   role="button" data-slide="next">
                                    <!--<span class="carousel-control-next-icon" aria-hidden="true"></span>-->
                                    <span class="fa fa-angle-right" style="color:red; font-size:2rem;"></span>

                                    <span class="sr-only">Next</span>
                                </a>
                            </div>


                            <?php } else { ?>
                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+images" alt="" id="def5"
                                 width="100%" style="height:350px" ;>

                            <?php } ?>


                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <script>

        var Select2 = {
            init: function () {
                $("#specific_fo, #specific_zone,#specific_outlet").select2({
                    placeholder: ""
                })
            }
        };
        jQuery(document).ready(function () {
            Select2.init()
        });

    </script>




    <script type="text/javascript" language="javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function () {
            $('#specific_zone,#specific_fo').change(function () {
                $("#specific_outlet > option").remove();
                //first of all clear select items
                var zone_id = $('#specific_zone').val();
                var fo_id = $('#specific_fo').val();

                // here we are taking country id of the selected one.
                $.ajax({
                    type: "POST",
                    url: '<?= route('visit.getOutletByZoneFo') ?>',
                    data: {_token: CSRF_TOKEN, zone_id: zone_id, fo_id: fo_id},
                    dataType: 'JSON',
                    success: function (data) {
                        $.each(data, function (id, out) {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(out);
                            $('#specific_outlet').append(opt);
                        });
                    }
                });

            });

        });
    </script>
@endsection