<!DOCTYPE html>

<html lang="en">


<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title><?php echo env('brand_name_title')?> | System</title>
    <link rel="shortcut icon" href="{{ asset('img/logo-cap.png') }}">
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--begin::Web font -->

    <link href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.4/themes/flick/jquery-ui.css" rel="stylesheet"
          type="text/css"/>
    <script src="{{ asset('vendors/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>

    <!--end::Web font -->
    <!-- begin:: Global Mandatory Vendors -->
    <link href="{{ asset('vendors/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css"/>

    <!--end:: Global Mandatory Vendors -->

    <!--begin:: amira -->
    <link href="{{ asset('vendors\bootstrap\dist\css\bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendors\bootstrap\dist\css\bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <!--end:: amira -->

    <!--begin:: Global Optional Vendors -->
    <link href="{{ asset('vendors/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('vendors/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('vendors/summernote/dist/summernote.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('vendors/socicon/css/socicon.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendors/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendors/vendors/flaticon/css/flaticon.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendors/vendors/metronic/css/styles.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendors/vendors/fontawesome5/css/all.min.css') }}" rel="stylesheet" type="text/css"/>

    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Styles -->

    <link href="{{ asset('assets/demo/demo5/base/style.bundle.css') }}" rel="stylesheet" type="text/css"/>

    <!--end::Global Theme Styles -->

    <!--begin::Page Vendors Styles -->
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Vendors Styles -->


{{--</head>

<head>--}}
<!-- Google Tag Manager -->

    <!-- End Google Tag Manager -->
    <meta charset="utf-8"/>


    <!--begin::Fonts-->

    <!--end::Fonts-->

    <!--begin::Page Vendors Styles(used by this page)-->
{{--<link href="{{ asset('theme/html/demo1/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundledf5a.css?v=7.2.6') }}"
      rel="stylesheet" type="text/css"/>--}}
<!--end::Page Vendors Styles-->


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


</head>
<style>
    .m-table.m-table--head-bg-danger thead th {
        background: #041981;
        color: #fff;
        border-bottom: 0;
        border-top: 0;
    }

    .aside-menu .menu-nav > .menu-item > .menu-link .menu-text {
        font-weight: 600;
        font-size: 1.15rem;
        text-transform: initial;
    }

    .header-fixed.subheader-fixed.subheader-enabled .wrapper {
        padding-top: 80px !important;
    }

     .m-badge.m-badge--danger {
        background-color: #f60808;
        color: #fff;
    }

    .m-badge.m-badge--primary {
        background-color: #003272;
        color: #fff;
    }

    .m-badge.m-badge--success {
        background-color: #2d6d34;
        color: #fff;
    }
    .table {
        font-size: 14px;
    }

    th, td {
        text-align: center !important;
    }

    .text-danger {
        color: #041981 !important;
    }
    .m-topbar .m-topbar__nav.m-nav>.m-nav__item.m-topbar__user-profile>.m-nav__link .m-topbar__username {
        display: table-cell;
        vertical-align: middle;
        text-transform: inherit;
        font-size: 1rem;
        font-weight: 500;
        text-align: left;
        color: #041981 !important;
        padding-right: 10px;
    }
</style>

<!--begin::Body-->
<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!-- Google Tag Manager (noscript) -->

<!-- End Google Tag Manager (noscript) -->
<!--begin::Main-->
<!--begin::Header Mobile-->
<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
    <!--begin::Logo-->
    <a href="https://preview.keenthemes.com/metronic/demo1/index.html">
        <img alt="Logo" src="../../../theme/html/demo1/dist/assets/media/logos/logo-dark.png"/>
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
        <!--begin::Aside Mobile Toggle-->
        <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
            <span></span>
        </button>
        <!--end::Aside Mobile Toggle-->
        <!--begin::Header Menu Mobile Toggle-->
        <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
            <span></span>
        </button>
        <!--end::Header Menu Mobile Toggle-->
        <!--begin::Topbar Mobile Toggle-->
        <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-md">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24"/>
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                      fill="#000000" fill-rule="nonzero" opacity="0.3"/>
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                      fill="#000000" fill-rule="nonzero"/>
							</g>
						</svg>
                        <!--end::Svg Icon-->
					</span>
        </button>
        <!--end::Topbar Mobile Toggle-->
    </div>
    <!--end::Toolbar-->
</div>
<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
            <!--begin::Brand-->
            <div class="brand flex-column-auto" id="kt_brand">
                <!--begin::Logo-->
  <a href="#" class="brand-logo">
                    <img src="https://dgc.cap.tn/assets/img/logo-cap-hd.png" style="margin-top:5%;width:120px;">
                </a>
                <!--end::Logo-->
                <!--begin::Toggle-->
                <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                    <span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24"></polygon>
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                              fill="#000000" fill-rule="nonzero"
                                              transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)"></path>
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                              fill="#000000" fill-rule="nonzero" opacity="0.3"
                                              transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)"></path>
									</g>
								</svg>
                        <!--end::Svg Icon-->
							</span>
                </button>
                <!--end::Toolbar-->
            </div>
            <!--end::Brand-->
            <!--begin::Aside Menu-->
            <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                <!--begin::Menu Container-->
                <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
                     data-menu-dropdown-timeout="500">
                    <!--begin::Menu Nav-->
                    <ul class="menu-nav">
                        <?php if(request()->session()->get('connected_user_acces') == 'Responsible' ) { ?>
                        <li class="menu-item {{ url()->current()== url('visit/orderReport') ? 'menu-item-open menu-item-here' : null }}"
                            aria-haspopup="true">
                            <a href="{{ url('visit/orderReport') }}" class="menu-link">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-clipboard-list {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Order Sales Resonsible</span>
                            </a>
                        </li>
                        <?php } else { ?>

                        <li class="menu-item {{ url()->current()== url('dashboard') ? 'menu-item-open menu-item-here' : null }}"
                            aria-haspopup="true">
                            <a href="{{ url('dashboard') }}" class="menu-link">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-home {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">@lang('project.TABLEAU_DE_BORD')</span>
                            </a>
                        </li>

                        <!--VISITS-->
                        <li class="menu-item menu-item-submenu
{{  Request::segment(1) === 'visit'|| url()->current()==url('report/stock_issue')  ? 'menu-item-open menu-item-here' : null }}"
                            aria-haspopup="true" data-menu-toggle="hover">

                            <a href="javascript:;" class="menu-link menu-toggle">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-briefcase {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Visits</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
													<span class="menu-text">Visits</span>
												</span>
                                    </li>

                                    <li class="menu-item {{ url()->current()== url('visit')? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('visit') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Daily</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()== url('visit/extrait_journalier') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('visit/extrait_journalier') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Data</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ url()->current()== url('visit/historique_pdv') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('visit/historique_pdv') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">POS</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ url()->current()==url('report/stock_issue') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('report/stock_issue') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Tracking oos</span>
                                        </a>
                                    </li>


                                    <li class="menu-item {{ url()->current()==url('visit/orderReport') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('visit/orderReport') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">order Sales Responsible</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <!--END VISITS-->

                        <!--NUMERIC DISTRIBUTION-->
                        <li class="menu-item menu-item-submenu {{  url()->current()==url('report/numeric_distribution') ||url()->current()== url('report/extarait_pdv_dn_report')  ? 'menu-item-open menu-item-here' : null }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md far fa-chart-bar {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Numeric Distribution</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
                                                    <span class="menu-text">Numeric Distribution</span>
												</span>
                                    </li>

                                    <li class="menu-item {{ url()->current()==url('report/numeric_distribution')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('report/numeric_distribution') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Stats</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ url()->current()==url('report/extarait_pdv_dn_report')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('report/extarait_pdv_dn_report') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">POS</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('report/dn_map') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('report/dn_map') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Map</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!--END DISTRIBUTION-->

                        <!--Shelf Share-->
                        <li class="menu-item menu-item-submenu {{ url()->current()==url('report/shelf_share') ||url()->current()== url('report/extarait_pdv_shelf_share_report')  ? 'menu-item-open menu-item-here' : null }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-align-center {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Shelf Share</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
                                                    <span class="menu-text">Shelf Share</span>
												</span>
                                    </li>

                                    <li class="menu-item {{ url()->current()==url('report/shelf_share')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('report/shelf_share') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Stats</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ url()->current()==url('report/extarait_pdv_shelf_share_report')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('report/extarait_pdv_shelf_share_report') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">POS</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <!--END Shelf Share-->

                        <!--Brandin-->
                        <li class="menu-item {{ url()->current()==url('visit/branding')   ? 'menu-item-active' : null }}"
                            aria-haspopup="true">
                            <a href="{{ url('visit/branding') }}" class="menu-link">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md far fa-images {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Branding</span>
                            </a>
                        </li>
                        <!--END Branding-->

                        <!--price monitoring-->
                        <li class="menu-item {{ url()->current()==url('report/price_monotoring')?'menu-item-active':null }}"
                            aria-haspopup="true">
                            <a href="{{ url('report/price_monotoring') }}" class="menu-link">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-dollar-sign {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Price Monitoring</span>
                            </a>
                        </li>
                        <!--end price monitoring-->


                        <!--Outlets-->
                        <li class="menu-item menu-item-submenu
                           {{  url()->current()==url('outlet/geolocalisation') ||
url()->current()==url('outlet')
? 'menu-item-open menu-item-here' : null }}

                                " aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-shopping-cart {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Outlets</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
                                                    <span class="menu-text">Outlets</span>
                                                </span>
                                    </li>

                                    <li class="menu-item {{  url()->current()==url('outlet/index') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('outlet.index') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Outlets DB</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{  url()->current()==url('outlet/geolocalisation') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('outlet.geolocalisation') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Geolocalisation</span>
                                        </a>
                                    </li>

                                <!--<li class="menu-item {{  url()->current()==url('report/shelf_map') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('report/shelf_map') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Shelf Share</span>
                                        </a>
                                    </li>-->

                                </ul>
                            </div>
                        </li>
                        <!--END Outlets-->

                        <!--Store Album-->
                        <li class="menu-item {{  url()->current()==url('report/store_album')? 'menu-item-active' : null }}"
                            aria-haspopup="true">
                            <a href="{{ url('report/store_album') }}" class="menu-link">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-camera-retro {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Store Album</span>
                            </a>
                        </li>
                        <!--end Store Album-->

                        <!--Fo Profile-->
                        <li class="menu-item {{  url()->current()==url('fo_report/foProfile')? 'menu-item-active' : null }}"
                            aria-haspopup="true">
                            <a href="{{ url('fo_report/foProfile') }}" class="menu-link">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md far fa-user {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Fo Profile</span>
                            </a>
                        </li>
                        <!--end Fo Profile-->
                        <!-- begin admin panel -->

                    <?php if(request()->session()->get('connected_user_acces') == 'Admin' ) {

                    ?>
                    <!--FO Performance-->
                        <li class="menu-item menu-item-submenu {{ Request::segment(2) === 'fo_report'
                               &&  url()->current()!=url('admin/fo_report/foProfile')
                                &&  url()->current()!=url('admin/fo_report/fo_information_input')
                                &&  url()->current()!=url('admin/fo_report/fo_information_output')
                                ? 'menu-item-open menu-item-here' : null }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-plane {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">FO Performance</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
                                                <span class="menu-text">FO Performance</span>

												</span>
                                    </li>

                                    <li class="menu-item {{  url()->current()==url('admin/fo_report/performance')? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/fo_report/performance') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Performance Report</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/fo_report/routing_trend')? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/fo_report/routing_trend') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Routing Trend</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()== url('admin/fo_report/routing_survey')? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/fo_report/routing_survey') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Routing Survey</span>
                                        </a>
                                    </li>
                                <!-- <li class="menu-item {{  url()->current()==  url('admin/fo_report/gps_monitoring')? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/fo_report/gps_monitoring') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">GPS Monitoring</span>
                                        </a>
                                    </li>-->

                                </ul>
                            </div>
                        </li>
                        <!--END FO Performance-->

                        <!--FO Information-->
                        <li class="menu-item menu-item-submenu
{{  url()->current()==url('admin/fo_report/fo_information_input')
                                ||  url()->current()==url('admin/fo_report/fo_information_output')
                                ? 'menu-item-open menu-item-here' : null }}
                                " aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-info {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">FO Information</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
                                              <span class="menu-text">FO Information</span>

												</span>
                                    </li>

                                    <li class="menu-item {{  url()->current()==url('admin/fo_report/fo_information_input')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.fo_report.fo_information_input') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Input</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/fo_report/fo_information_output')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/fo_report/fo_information_output') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Output</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <!--END FO Information-->

                        <!--Administration-->
                        <li class="menu-item menu-item-submenu
                           {{url()->current()== url('admin/upload/index')
||
url()->current()== url('outlet/ha_outlets')
||
url()->current()== url('visit/trackingVisitsReport')
||
url()->current()== url('admin/user/index')
||
url()->current()==url('admin/outlet')
||
url()->current()==url('admin/brand')
||
url()->current()==url('admin/product')
||
url()->current()==url('admin/product_group')
||
url()->current()==url('admin/cluster')
||
url()->current()==url('admin/sub_category')
||
url()->current()==url('admin/category')
||
url()->current()== url('admin/zone')
||
url()->current()==url('admin/channel')
||
url()->current()==url('admin/sub_channel')
||
url()->current()==url('admin/state')
? 'menu-item-open menu-item-here' : null }}

                                " aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md fas fa-cog {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Administration</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
                                                    <span class="menu-text">Administration</span>
                                                </span>
                                    </li>

                                    <li class="menu-item {{  url()->current()== url('admin/upload/index') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/upload/index') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">List Of APK</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{  url()->current()==url('outlet/ha_outlets') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('outlet/ha_outlets') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">HA Products</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ url()->current()== url('visit/trackingVisitsReport') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('visit/trackingVisitsReport') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Tracking visits</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/user/index') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/user/index') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Users</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/outlet')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/outlet') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Outlets</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/brand')? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/brand') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Brands</span>
                                        </a>
                                    </li>
                                    {{--     <li class="menu-item"
                                             aria-haspopup="true">
                                             <a href="#"
                                                class="menu-link">
                                                 <i class="menu-bullet menu-bullet-dot">
                                                     <span></span>
                                                 </i>
                                                 <span class="menu-text">Targets</span>
                                             </a>
                                         </li>--}}
                                    <li class="menu-item {{  url()->current()==url('admin/product') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/product') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Products</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/product_group') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/product_group') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Product groups</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/cluster') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/cluster') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Clustering</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()== url('admin/sub_category') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/sub_category') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Sub Categories</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/category')? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/category') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Categories</span>
                                        </a>
                                    </li>
                                    {{--<li class="menu-item {{  url()->current()==url('outlet') ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="#"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Geolocalisation</span>
                                        </a>
                                    </li>--}}

                                    <li class="menu-item {{  url()->current()==url('admin/zone')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/zone') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Zones</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/channel')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/channel') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Channels</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/sub_channel')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/sub_channel') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Sub Channels</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{  url()->current()==url('admin/state')  ? 'menu-item-active' : null }}"
                                        aria-haspopup="true">
                                        <a href="{{ url('admin/state') }}"
                                           class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">States</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <!-- end admin panel -->
                    <?php }

                    ?>

                    <!--Message-->
                        <!--<li class="menu-item" aria-haspopup="true">
                            <a href="{{ url('user/messages') }}" class="menu-link">
                                <div class="mr-4 flex-shrink-0 text-center">
                                    <i class="icon-md far fa-comment-dots {{env('iconColor')}}"></i>
                                </div>
                                <span class="menu-text">Message</span>
                            </a>
                        </li>-->
                    <?php }?>
                    <!--END Message-->
                    </ul>
                    <!--end::Menu Nav-->
                </div>
                <!--end::Menu Container-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside-->
        <!--begin::Wrapper-->

        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" class="header header-fixed">
                <!--begin::Container-->
                <div class="container-fluid d-flex align-items-stretch justify-content-between">
                    <!--begin::Header Menu Wrapper-->
                    <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                        <!--begin::Header Menu-->
                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                            <!--begin::Header Nav-->
                            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                <!--begin::Header Nav-->
                                <ul class="menu-nav">
                                    <li class="menu-item menu-item-submenu menu-item-rel menu-item-active"
                                        data-menu-toggle="click" aria-haspopup="true">
                                        <a href="{{ url('dashboard') }}" class="m-brand__logo-wrapper">
                                            <img alt="" src="{{ asset('img/'. env('logo_name')) }}" height="45px"/>
                                        </a>
                                    </li>
                                </ul>
                                <!--end::Header Nav-->
                            </div>
                            <!--end::Header Nav-->
                        </div>
                        <!--end::Header Menu-->
                    </div>
                    <!--end::Header Menu Wrapper-->
                    <!--begin::Topbar-->
                    <div class="topbar">
                        <div class="topbar-item">

                        </div>
                        <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                            <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                                <div class="m-stack__item m-topbar__nav-wrapper">
                                    <ul class="m-topbar__nav m-nav m-nav--inline">
                                    <!-- <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                            m-dropdown-toggle="click">
                                            <?php
                                    $selectedLang = request()->session()->get('connected_user_lang');
                                    ?>
                                            <select id="lang" class="form-control mt-2">
                                                <option value="fr" <?php if ($selectedLang == 'fr') echo 'selected'; ?>>
                                                    FR
                                                </option>

                                                <option value="en" <?php if ($selectedLang == 'en') echo 'selected'; ?>>
                                                    EN
                                                </option>
                                            </select>
                                        </li>-->
                                        <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                            m-dropdown-toggle="click">

                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-topbar__welcome">Hello,&nbsp;</span>
                                                <span class="m-topbar__username">

                                                    {{session()->get('connected_user_name')}}

                                                </span>

                                                <?php
                                                if ((request()->session()->get('connected_user_photo')) && (request()->session()->get('connected_user_photo')) != '' && (request()->session()->get('connected_user_photo')) != NULL)
                                                    $image = request()->session()->get('connected_user_photo');
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
                                                                <span class="m-card-user__name m--font-weight-500">{{request()->session()->get('connected_user_name')}}</span>
                                                                <a href=""
                                                                   class="m-card-user__email m--font-weight-300 m-link">{{request()->session()->get('connected_user_email')}}</a>
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

                    </div>

                    <!--end::Topbar-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Header-->

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


            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Subheader-->
                <div class="m-subheader ">

                    <div class="row">
                        <div class="col-md-12">
                            @if(request()->session()->has('message'))
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    </button>
                                    {{ request()->session()->get('message') }}
                                </div>

                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    </button>
                                    @foreach($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--end::Subheader-->
                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Dashboard-->


                        @yield('content')
                        <!--begin::Row-->

                            <!--end::Row-->
                            <!--begin::Row-->

                            <!--end::Row-->
                            <!--end::Dashboard-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">

                            2019 &copy; MERCHANDISING SYSTEM by <a href="https://beesoft.tn/" class="m-link">BEESOFT</a>
                        </div>
                        <!--end::Copyright-->
                        <!--begin::Nav-->
                        <div class="nav nav-dark">

                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
    <!-- begin::User Panel-->

    <!-- end::User Panel-->
    <!--begin::Quick Cart-->

    <!--end::Quick Cart-->
    <!--begin::Quick Panel-->

    <!--end::Quick Panel-->
    <!--begin::Chat Panel-->

    <!--end::Chat Panel-->
    <!--begin::Scrolltop-->

    <!--end::Scrolltop-->
    <!--begin::Sticky Toolbar-->

    <!--end::Sticky Toolbar-->
    <!--begin::Demo Panel-->

    <!--end::Demo Panel-->

    <!--end::Body-->

@include('layouts.admin.footer')