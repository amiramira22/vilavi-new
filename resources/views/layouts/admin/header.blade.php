<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title><?php echo env('brand_name')?> | System</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.4/themes/flick/jquery-ui.css" rel="stylesheet"
          type="text/css">
    <script src="{{ asset('vendors/jquery/dist/jquery.js') }}"></script>


    <script src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>


    <!--end::Web font -->
    <!-- begin:: Global Mandatory Vendors -->
    <link href="{{ asset('vendors/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css">

    <!--end:: Global Mandatory Vendors -->

    <!--begin:: amira -->
    <link href="{{ asset('vendors\bootstrap\dist\css\bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors\bootstrap\dist\css\bootstrap.css') }}" rel="stylesheet" type="text/css">

    <!--end:: amira -->

    <!--begin:: Global Optional Vendors -->
    <link href="{{ asset('vendors/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('vendors/summernote/dist/summernote.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('vendors/socicon/css/socicon.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/vendors/flaticon/css/flaticon.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/vendors/metronic/css/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/vendors/fontawesome5/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Styles -->

    <link href="{{ asset('assets/demo/demo5/base/style.bundle.css') }}" rel="stylesheet" type="text/css">

    <!--end::Global Theme Styles -->

    <!--begin::Page Vendors Styles -->
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('theme/html/demo1/dist/assets/plugins/global/plugins.bundledf5a.css?v=7.2.6') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('theme/html/demo1/dist/assets/plugins/custom/prismjs/prismjs.bundledf5a.css?v=7.2.6') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('theme/html/demo1/dist/assets/css/style.bundledf5a.css?v=7.2.6') }}" rel="stylesheet"
          type="text/css"/>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('theme/html/demo1/dist/assets/css/themes/layout/header/base/lightdf5a.css?v=7.2.6') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('theme/html/demo1/dist/assets/css/themes/layout/header/menu/lightdf5a.css?v=7.2.6') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('theme/html/demo1/dist/assets/css/themes/layout/brand/lightdf5a.css?v=7.2.6') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('theme/html/demo1/dist/assets/css/themes/layout/aside/lightdf5a.css?v=7.2.6') }}"
          rel="stylesheet" type="text/css"/>
    <!--end::Layout Themes-->
    <link rel="shortcut icon" type="image/x-icon" href="">

</head>

<!-- end::Head -->

<!-- begin::Body -->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable aside-minimize">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">

    <!-- begin::Header -->
    <header id="m_header" class="m-grid__item m-header " m-minimize="minimize" m-minimize-offset="200"
            m-minimize-mobile-offset="200">
        <div class="m-header__top">
            <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
                <div class="m-stack m-stack--ver m-stack--desktop">

                    <!-- begin::Brand -->
                    <div class="m-stack__item m-brand">
                        <div class="m-stack m-stack--ver m-stack--general m-stack--inline">
                            <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                <a href="{{ url('admin/dashboard') }}" class="m-brand__logo-wrapper">
                                    <img alt="" src="{{ asset('img/logo-henkel-hd.png') }}" height="45px"/>
                                </a>

                            </div>
                            <div class="m-stack__item m-stack__item--middle m-brand__tools">

                                <!-- begin::Responsive Header Menu Toggler-->
                                <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                                   class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                                    <span></span>
                                </a>

                                <!-- end::Responsive Header Menu Toggler-->

                                <!-- begin::Topbar Toggler-->
                                <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                                   class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                    <i class="flaticon-more"></i>
                                </a>
                                <!--end::Topbar Toggler-->
                            </div>

                        </div>
                    </div>

                    <!-- end::Brand -->

                    <!-- begin::Topbar -->


                    <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                        <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                            <div class="m-stack__item m-topbar__nav-wrapper">
                                <ul class="m-topbar__nav m-nav m-nav--inline">
                                    <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                        m-dropdown-toggle="click">
                                        <?php
                                        $selectedLang = Session::get('connected_user_lang');
                                        ?>
                                        <select id="lang" class="form-control mt-2">
                                            <option value="fr" <?php if ($selectedLang == 'fr') echo 'selected'; ?>>
                                                FR
                                            </option>

                                            <option value="en" <?php if ($selectedLang == 'en') echo 'selected'; ?>>
                                                EN
                                            </option>
                                        </select>
                                    </li>
                                    <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                        m-dropdown-toggle="click">

                                        <a href="#" class="m-nav__link m-dropdown__toggle">
                                            <span class="m-topbar__welcome">Hello,&nbsp;</span>
                                            <span class="m-topbar__username">{{Session::get('connected_user_name')}}</span>

                                            <?php
                                            if ((Session::get('connected_user_photo')) && (Session::get('connected_user_photo')) != '' && (Session::get('connected_user_photo')) != NULL)
                                                $image = Session::get('connected_user_photo');
                                            else
                                                $image = 'user.png';
                                            ?>
                                            <span class="m-topbar__userpic">
                                                        <img src="{{ asset('users/'.$image) }}"
                                                             class="m--img-rounded m--marginless m--img-centered"
                                                             alt=""/>
                                                    </span>
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__header m--align-center">
                                                    <div class="m-card-user m-card-user--skin-dark">
                                                        <div class="m-card-user__pic">
                                                            <img src="{{ asset('users/'.$image) }}"
                                                                 class="m--img-rounded m--marginless" alt=""/>
                                                        </div>
                                                        <div class="m-card-user__details">
                                                            <span class="m-card-user__name m--font-weight-500">{{Session::get('connected_user_name')}}</span>
                                                            <a href=""
                                                               class="m-card-user__email m--font-weight-300 m-link">{{Session::get('connected_user_email')}}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav m-nav--skin-light">
                                                            <li class="m-nav__item">
                                                                <a href="{{ url('logout') }}"
                                                                   class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- end::Topbar -->
                </div>
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>

        <script>

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $('#lang').change(function () {
                var lang = $(this).val();


                $.ajax({
                    type: 'POST',
                    url: '<?= route('changeLang') ?>',
                    data: {
                        _token: CSRF_TOKEN,
                        lang: lang
                    },
                    success: function (data) {

                        if (data == 1) {
                            //console.log('change lang');
                            location.reload();


                        }
                    }
                });

            });
        </script>

        @include('layouts.admin.sidebar')




{{--                @include('layouts.admin.navbar')--}}
