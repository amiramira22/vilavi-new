<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name') }}  @yield('title')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="author" />
        <style>


            .portlet.light.portlet-fit > .portlet-title {
                padding: 0px 0px 0px 0px !important;
            }   
            @media (max-width: 767px)
            {
                .page-header.navbar .page-top {
                    background: #ffffff !important;
                }
                .page-header.navbar {
                    background: #ffffff!important;
                    border-bottom: 1px solid #ffffff!important;
                }   
            }
        </style>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        {!!Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')!!}
        {!!Html::style('plugins/font-awesome/css/font-awesome.min.css')!!}
        {!!Html::style('plugins/simple-line-icons/simple-line-icons.min.css')!!}
        {!!Html::style('plugins/bootstrap/css/bootstrap.min.css')!!}
        {!!Html::style('plugins/bootstrap-switch/css/bootstrap-switch.min.css')!!}
        <!-- END GLOBAL MANDATORY STYLES -->


        <!-- BEGIN THEME GLOBAL STYLES -->
        {!!Html::style('css/components-rounded.css')!!}
        {!!Html::style('css/plugins.css')!!}
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        {!!Html::style('css/layout.css')!!}
        {!!Html::style('css/themes/default.css')!!}
        {!!Html::style('css/custom.css')!!}
        <!-- BEGIN Datatables STYLES -->
        {!!Html::style('plugins/datatables/DataTables-1.10.16/css/dataTables.bootstrap.css')!!}
        {!!Html::style('plugins/datatables/Buttons-1.5.1/css/buttons.bootstrap.css')!!}
        <!-- END Datatables STYLES -->

        @yield('stylesheet')

        {!!Html::script('plugins/jquery.min.js')!!}
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->


    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">

         <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="#">
                    </a>
                    <br>
                    <img src="{{asset('img/logo.png')}}" style="width:150px" class="img-responsive">

                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <!--<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>-->
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="page-top">
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li style=" padding-top: 15px;">
                                <a href="#">

                                    <span class="username " style="color:#000000"> {{ Auth::user()->name }}  </span>
                                </a>

                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->


                           
                            <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>    



