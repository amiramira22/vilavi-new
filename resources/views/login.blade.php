<!DOCTYPE html>

<html lang="en">

    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title><?php echo env('brand_name_title') ?> | System</title>
        <link rel="shortcut icon" href="{{ asset('img/logo-cap.png') }}">
        <meta name="description" content="Latest updates and statistic charts">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

        <!--begin::Web font -->
        <script src="http://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
            WebFont.load({
                google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
                active: function () {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <style>
            .m-login.m-login--2 .m-login__wrapper {
                padding: 4% 2rem 1rem 2rem !important;
                margin: 0 auto 2rem auto;
                overflow: hidden;
            }
            .m-login.m-login--2 .m-login__wrapper .m-login__container .m-login__logo {
                text-align: center;
                margin: 0 auto 0rem auto !important;
            }
            .btn-focus {
                color: #fff;
                background-color: #0d739f !important;
                border-color: #0d739f !important;
            }
        </style>
        <!--end::Web font -->
        <script src="{{ asset('vendors/jquery/dist/jquery.js') }}"></script>

        <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css"> 
        <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css">
        <!--<link href="{{ asset('assets/demo/base/style.bundle.css') }}" rel="stylesheet" type="text/css">--> 


    </head>
    <style>
        .btn-focus {
            color: #fff;
            background-color: #041981!important;
            border-color: #041981!important;
        }

    </style>
    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(public/assets/app/media/img//bg/bg-3.jpg);">
                <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                    <div class="m-login__container">


                        <div class="m-login__logo">
                            <a href="#">
                                <img src="public/img/<?php echo env('logo_name')?>" style="height: 100px;">
                            </a>
                        </div>
                        <div class="m-login__signin">
                            <div class="m-login__head">
                                <h3 class="m-login__title">Sign In To User</h3>
                            </div>

                            <form class="m-login__form m-form" action="{{ url('login') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group m-form__group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if(request()->session()->has('message'))
                                            <center><h6><span class="m--font-danger">{{ request()->session()->get('message') }}</span></h6></center>
                                            @endif
                                        </div>
                                    </div>
                                    <input class="form-control m-input" type="text" placeholder="Username" name="username" autocomplete="off" required>
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password" required>
                                </div>
                                <div class="row m-login__form-sub">
                                    <div class="col m--align-left m-login__form-left">
                                        <label class="m-checkbox  m-checkbox--focus">
                                            <input type="checkbox" name="remember"> Remember me
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col m--align-right m-login__form-right">
                                        <a href="#" id="" class="m-link">Forget Password ?</a>
                                    </div>
                                </div>
                                <div class="m-login__form-action">
                                    <button type="submit" id="" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Sign In</button>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Page -->


        <!--begin::Global Theme Bundle -->

<!--        <script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}"></script>
        <script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}"></script>-->

        <script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}"></script>

        <!--end::Global Theme Bundle -->

        <!--begin::Page Scripts -->
        <script src="{{ asset('assets/snippets/custom/pages/user/login.js') }}"></script>

        <!--end::Page Scripts -->
    </body>

    <!-- end::Body -->
</html>