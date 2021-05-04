<style>

    .m-header-menu.m-header-menu--skin-dark .m-menu__nav>.m-menu__item.m-menu__item--active>.m-menu__link .m-menu__link-text {
        color: #ec0928 !important;
    }

    .m-header-menu.m-header-menu--skin-dark .m-menu__nav>.m-menu__item>.m-menu__link .m-menu__link-text {
        color: #0968a8;
    }

    .m--font-danger {
        color: #ec0928 !important;
    }

    .m--bg-danger {
        background-color: #ec0928 !important;
    }

    .{{env('iconColor')}} {
        color: #0968a8 !important;
    }

    .m--bg-brand {
        background-color: #0968a8 !important;
    }

    a {
        color: #0968a8;
    }

    .m-topbar .m-topbar__nav.m-nav>.m-nav__item.m-topbar__user-profile>.m-nav__link .m-topbar__username {

        color: #ec0928 !important;

    }
    .m-portlet.m-portlet--danger.m-portlet--head-solid-bg .m-portlet__head {
        background-color: #ec0928 !important;
        border-color: #ec0928 !important;
    }
    .btn.btn-outline-danger {
        color: #ec0928 !important;
    }

    .btn-outline-danger.focus, .btn-outline-danger:focus, .btn-outline-danger:hover {
        border-color: #ec0928 !important;
        background: #ec0928 !important;
        color: #fff;
    }

    .btn-outline-primary:not(:disabled):not(.disabled):active, .btn-outline-primary:not(:disabled):not(.disabled).active, .show>.btn-outline-primary.dropdown-toggle {
        color: #fff;
        background-color: #0968a8 !important;
        border-color: #0968a8 !important;
    }


    .btn.btn-outline-primary {
        color: #0968a8 !important;
    }

    .btn.m-btn--label-primary {
        color: #0968a8;
    }

    .m-table.m-table--head-bg-brand thead th {
        background: #0968a8 !important;

    }
</style>



<div class="m-header__bottom">
    <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
        <div class="m-stack m-stack--ver m-stack--desktop">

            <!-- begin::Horizontal Menu -->
            <div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
                    <i class="fas fa-close"></i>
                </button>

                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light ">
                    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                        <span style="padding-left:30px;"></span>
                        <li class="m-menu__item {{ Request::segment(2) === 'dashboard' ? 'm-menu__item--active' : null }}" aria-haspopup="true">
                            <a href="{{ url('admin/dashboard') }}" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">@lang('project.TABLEAU_DE_BORD')</span>
                            </a>
                        </li>

                        <!--VISITS-->
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel {{ Request::segment(2) === 'visit' ? 'm-menu__item--active' : null }}" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link">

                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    @lang('project.VISITE')s
                                </span>
                                <i class="m-menu__hor-arrow fas fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fas fa-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:300px">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <div class="m-menu__subnav">

                                    <ul class="m-menu__content">
                                        <li class="m-menu__item">
                                            <br>
                                            <ul class="m-menu__inner">

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/visit') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text"> @lang('project.TEMPS_REEL')</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/visit/extrait_journalier') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.EXTRAIT_JOURNALIER')</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/visit/historique_pdv') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.HISTORIQUE_PDV')</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/visit/branding') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.BRANDING')</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/visit/trackingVisitsReport') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">Tracking visits</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!--END VISITS-->

                        <!--REPORTS-->
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel {{ Request::segment(2) === 'report' ? 'm-menu__item--active' : null }}" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">@lang('project.RAPPORT')s</span>
                                <i class="m-menu__hor-arrow fas fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fas fa-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:900px">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <div class="m-menu__subnav">

                                    <ul class="m-menu__content">

                                        <li class="m-menu__item">
                                            <ul class="m-menu__inner">
                                                <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">@lang('project.DISTRIBUTION_NUMERIQUE')</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/report/numeric_distribution') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.ANALYSE')</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/report/extarait_pdv_dn_report') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.EXTRAIT_PDV')</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/report/dn_map') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text" style="white-space: nowrap;">@lang('project.CARTOGRAPHIE')</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>


                                        <li class="m-menu__item">
                                            <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">@lang('project.PART_DE_LINEAIRE')</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                            <ul class="m-menu__inner">

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/report/shelf_share') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.ANALYSE')</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/report/extarait_pdv_shelf_share_report') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.EXTRAIT_PDV')</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/report/shelf_map') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text" style="white-space: nowrap;">@lang('project.CARTOGRAPHIE')</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="m-menu__item">
                                            <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">@lang('project.PRIX')</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                            <ul class="m-menu__inner">
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/report/price_monotoring') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text" style="white-space: nowrap;">@lang('project.EXTRAIT')</span>
                                                    </a>
                                                </li>
                                                <!--                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                                                                    <a href="#" class="m-menu__link ">
                                                                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                                                                            <span></span></i><span class="m-menu__link-text" style="white-space: nowrap;">@lang('project.EXTRAIT')</span>
                                                                                                    </a>
                                                                                                </li>-->
                                            </ul>
                                        </li>
                                        <li class="m-menu__item">
                                            <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">@lang('project.STOCK_ISSUE')</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                            <ul class="m-menu__inner">
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/report/stock_issue') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.DETAIL')s</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>






                                        <!--                                        <li class="m-menu__item">
                                                                                    <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Mapping</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                                                                    <ul class="m-menu__inner">
                                                                                        <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                                                            <a href="{{ url('admin/report/gelocalisation') }}" class="m-menu__link ">
                                                                                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                                                                    <span></span></i><span class="m-menu__link-text">Geolocalisation</span>
                                                                                            </a>
                                                                                        </li>

                                                                                        <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                                                            <a href="{{ url('admin/report/dn_map') }}" class="m-menu__link ">
                                                                                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                                                                    <span></span></i><span class="m-menu__link-text" style="white-space: nowrap;"> Numeric Distribution</span>
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </li>-->

                                        <!--                                        <li class="m-menu__item">
                                                                                    <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Pictures</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                                                                    <ul class="m-menu__inner">
                                                                                        <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                                                            <a href="{{ url('admin/report/branding') }}" class="m-menu__link ">
                                                                                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                                                                    <span></span></i><span class="m-menu__link-text">Branding</span>
                                                                                            </a>
                                                                                        </li>

                                                                                        <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                                                            <a href="{{ url('admin/report/store_album') }}" class="m-menu__link ">
                                                                                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                                                                    <span></span></i><span class="m-menu__link-text">Store Album</span>
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </li>-->
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!--END REPORTS-->


                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel {{ Request::segment(2) === 'outlet' ? 'm-menu__item--active' : null }}" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link">

                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    @lang('project.OUTLET')s
                                </span>
                                <i class="m-menu__hor-arrow fas fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fas fa-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:300px">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <div class="m-menu__subnav">

                                    <ul class="m-menu__content">
                                        <li class="m-menu__item">
                                            <br>
                                            <ul class="m-menu__inner">

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/outlet') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text"> @lang('project.BASE_DE_DONNEES')</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/outlet/geolocalisation') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.GEOLOCALISATION')</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>


                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel {{ Request::segment(2) === 'fo_report' ? 'm-menu__item--active' : null }}" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">@lang('project.MERCHANDISER')s</span>
                                <i class="m-menu__hor-arrow fas fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fas fa-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:700px">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <div class="m-menu__subnav">
                                    <ul class="m-menu__content">
                                        <li class="m-menu__item">
                                            <ul class="m-menu__inner">
                                                <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">@lang('project.MERCHANDISER_PROFILES')</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/fo_report/foProfile') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.PROFILE')s</span>
                                                    </a>
                                                </li>

                                                <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">@lang('project.INFORMATION_MERCHANDISER')</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/fo_report/fo_information_output') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.DETAIL')s</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>


                                        <li class="m-menu__item">
                                            <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Follow-Up</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                            <ul class="m-menu__inner">
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/fo_report/performance') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text" title="">@lang('project.KPI')</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/fo_report/routing_trend') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">

                                                            Routing (Day Vs Day)
                                                            <!--@lang('project.PLAN_DE_ROUTE')-->

                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/fo_report/routing_survey') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">

                                                            Routing Survey
                                                            <!--@lang('project.ROUTING_SURVEY')-->
                                                        </span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/fo_report/gps_monitoring') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.GPS_MONITORING')</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel {{ ((Request::segment(2) !== 'dashboard') && (Request::segment(2) !== 'visit') && (Request::segment(2) !== 'report') && (Request::segment(2) !== 'fo_report'))  ? 'm-menu__item--active' : null }}" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">@lang('project.ADMINISTRATION')</span>
                                <i class="m-menu__hor-arrow fas fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fas fa-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:700px">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <div class="m-menu__subnav">
                                    <ul class="m-menu__content">
                                        <li class="m-menu__item">
                                            <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">@lang('project.GESTION_PRODUCTS')</span><i class="m-menu__ver-arrow fas fa-angle-riPRODUCT_GESTIONght"></i></h3>
                                            <ul class="m-menu__inner">

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/brand') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.BRAND')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/category') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.CATEGORIE')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/sub_category') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.SUB_CATEGORIE')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/cluster') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.CLUSTER')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/product_group') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.PRODUCT_GROUPS')</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/product') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.PRODUCT')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/outlet/ha_outlets') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.HA_PRODUCTS')</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li class="m-menu__item">
                                            <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">@lang('project.GESTION_OUTLETS')</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                            <ul class="m-menu__inner">
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/outlet') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.OUTLET')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/state') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.STATE')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/zone') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.ZONE')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/channel') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.CHANNEL')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/sub_channel') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.SUB_CHANNEL')s</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li class="m-menu__item">
                                            <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">@lang('project.ADMINISTRATION')</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></h3>
                                            <ul class="m-menu__inner">
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/user/index') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.USER')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/user/messages') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.MESSAGE')s</span>
                                                    </a>
                                                </li>

                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="{{ url('admin/upload/index') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                                            <span></span></i><span class="m-menu__link-text">@lang('project.APP_ANDROID')</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>




                    </ul>
                </div>
            </div>

            <!-- end::Horizontal Menu -->

            <!--begin::Search-->

            <!--end::Search-->
        </div>
    </div>
</div>
</header>



<script type="text/javascript">
//    $(document).ready(function () {
//
//        $("li").click(function (e) {
//            e.preventDefault();
//            $(this).siblings().removeClass("m-menu__item--active").end().addClass("m-menu__item--active");
//
//        });
//    });
//    $(document).ready(function () {
//        $("ul:eq(1) > li").click(function () {
//            $('ul:eq(1) > li').removeClass("m-menu__item--active");
//            $(this).addClass("m-menu__item--active");
//        });
//    })



</script>
<script type="text/javascript">
//    $("li a").bind('click', function () {
//        $("li").removeClass("m-menu__item--active");
//        $(this).addClass("m-menu__item--active");
//    });
//    
//    
//    $("li").click(function (e) {
//        e.preventDefault();
//        $(this).siblings().removeClass("m-menu__item--active").end().addClass("m-menu__item--active");
//
//    });
</script>
<!-- end::Header -->		