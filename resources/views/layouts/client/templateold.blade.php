

<!DOCTYPE html>

<html lang="en">


    <head>
        <meta charset="utf-8" />
        <title>CAP Solutions | Survey Portal</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->

        {!!Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')!!}

        {!!Html::style('plugins/font-awesome/css/font-awesome.min.css')!!}
        {!!Html::style('plugins/simple-line-icons/simple-line-icons.min.css')!!}
        {!!Html::style('plugins/bootstrap/css/bootstrap.min.css')!!}
        {!!Html::style('plugins/uniform/css/uniform.default.css')!!}
        {!!Html::style('plugins/bootstrap-switch/css/bootstrap-switch.min.css')!!}
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        {!!Html::style('css/components-rounded.css')!!}
        {!!Html::style('css/plugins.min.css')!!}
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        {!!Html::style('css/layout.min.css')!!}
        {!!Html::style('css/light.css')!!}
        {!!Html::style('css/custom.min.css')!!}
        <!-- BEGIN Datatables STYLES -->
        {!!Html::style('plugins/datatables/DataTables-1.10.16/css/dataTables.bootstrap.css')!!}
        {!!Html::style('plugins/datatables/Buttons-1.5.1/css/buttons.bootstrap.css')!!}
        <!-- END Datatables STYLES -->

        {!!Html::style('plugins/bootstrap-multiselect/css/bootstrap-multiselect.css')!!}


        {!!Html::style('css/jquery-ui.css')!!}

        {!!Html::script('plugins/jquery.min.js')!!}
        {!!Html::script('js/jquery-ui.js')!!}

        {!!Html::script('plugins/amcharts/amcharts.js')!!}
        {!!Html::script('plugins/amcharts/pie.js')!!}
        {!!Html::script('plugins/amcharts/serial.js')!!}

        {!!Html::script('plugins/amcharts/plugins/export/export.min.js')!!}
        {!!Html::style('plugins/amcharts/plugins/export/export.css')!!}
        {!!Html::script('plugins/amcharts/themes/light.js')!!}

        <style>
            .table{
                margin-left: 10px;
                margin-right: 10px;
            }
        </style>



        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
        <!-- BEGIN HEADER -->
        @include('layouts.client.header')
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            @include('layouts.client.sidebar')
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!--
                    <div class="page-head">
                      
                                        <div class="page-title">
                                         
                                            <h1 class="page-title">  @if(isset($title)) {{ $title }} @else  @endif
                                                 
                                            <small> @if(isset($subTitle)) {{ $subTitle }}  @endif </small>
                                           </h1>
                                        </div>
                   
                    </div>
                    -->

                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->

                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->

                    <div class="row">
                        <div class="col-md-12">
                            @if(request()->session()->has('message'))

                            <div class="alert alert-success">

                                <a class="close" data-dismiss="alert">Ã—</a>
                                {{ request()->session()->get('message') }}
                            </div>
                            @endif

                            @if($errors->any())                   

                            <div class="alert alert-danger">

                                <a class="close" data-dismiss="alert">Ã—</a>
                                @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    </br>



                    @yield('content')





                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->

        </div>
        <!-- END CONTAINER -->
        
        @include('layouts.client.footer')


    </body>

</html>