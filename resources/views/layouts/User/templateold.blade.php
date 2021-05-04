@include('layouts.user.header')
<!-- BEGIN CONTAINER -->
<div class="page-container">
   
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
<!--                <div class="page-title">
                    <h1>
                        @if(isset($title)) {{ $title }} @else Home @endif
                        <small>@if(isset($subTitle)) {{ $subTitle }}  @endif </small>
                    </h1>
                </div>-->
                <!-- END PAGE TITLE -->
                <!-- BEGIN PAGE TOOLBAR -->
                
                <!-- END PAGE TOOLBAR -->
            </div>
            <!-- END PAGE HEAD-->
            <br/>

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

            @yield('content')






            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <a href="javascript:;" class="page-quick-sidebar-toggler">
        <i class="icon-login"></i>
    </a>

    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
@include('layouts.user.footer')