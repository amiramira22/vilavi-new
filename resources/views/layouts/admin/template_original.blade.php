@include('layouts.admin.header')


<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-page__container m-body">

    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
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

            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h4 class="m-subheader__title m-subheader__title--separator ">
                        @if(isset($title))  
                        <a href="#" class="m-menu__link ">
                            <span style="text-transform: uppercase ;font-size: 1.4rem !important">{{ $title }}</span>
                        </a> @endif
                    </h4>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">


                        <li class="m-nav__item">
                            <a href="#" class="m-nav__link">
                                <span class="m-nav__link-text">@if(isset($subTitle)) {{ $subTitle }}  @endif</span>
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->

        <div class="m-content">

            <style>
                .col-lg-6, .col-lg-9{
                    position: relative;
                    width: 100%;
                    min-height: 1px;
                    padding-right: 0px !important;
                    padding-left: 0px !important;
                }
/*                .col-lg-2{
                    margin-right: 10px !important;

                }*/

                .m-form .m-form__group {
                    margin-bottom: 0;
                    padding-top: 6px;
                    padding-bottom: 6px;
                }
                .m-body .m-content {
                    padding: 10px 30px;
                }
                .m-subheader {
                    padding: 30px 30px 0 40px;
                }
                body{
                    font-weight: 300;
                }

                .table {
                    font-size: 13px;
                }
                td{
                    text-align: center;
                    width: 125px;
                }

                th{

                    text-align: center;
                    width: 125px;
                }

                .m-portlet .m-portlet__body {
                    padding: 1rem 2.2rem;
                }

                .m-form .m-form__actions {
                    padding: 15px;
                }

            </style>
            <!--Begin::Section-->

            @yield('content')


            <!--End::Section-->
        </div>
    </div>
</div>

<!-- end::Body -->
@include('layouts.admin.footer')