<!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> {{ date('Y')}} &copy; Survey System By
                <a target="_blank" href="">Beesoft</a> &nbsp;|&nbsp;
               
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
       
        
       
  
        <!-- BEGIN CORE PLUGINS -->
       
        {!!Html::script('plugins/bootstrap/js/bootstrap.min.js')!!}
        {!!Html::script('plugins/js.cookie.min.js')!!}
        {!!Html::script('plugins/jquery-slimscroll/jquery.slimscroll.min.js')!!}
        {!!Html::script('plugins/jquery.blockui.min.js')!!}
        {!!Html::script('plugins/bootstrap-switch/js/bootstrap-switch.min.js')!!}
        <!-- END CORE PLUGINS -->
        
        <!-- BEGIN DATATABLES PLUGINS -->
        {!!Html::script('plugins/datatables/DataTables-1.10.16/js/jquery.dataTables.js')!!}
        {!!Html::script('plugins/datatables/DataTables-1.10.16/js/dataTables.bootstrap.js')!!}
        {!!Html::script('plugins/datatables/Buttons-1.5.1/js/dataTables.buttons.js')!!}
        {!!Html::script('plugins/datatables/Buttons-1.5.1/js/buttons.bootstrap.js')!!}
        
        {!!Html::script('plugins/datatables/Buttons-1.5.1/js/buttons.flash.js')!!}
        {!!Html::script('plugins/datatables/Buttons-1.5.1/js/buttons.html5.js')!!}
        {!!Html::script('plugins/datatables/Buttons-1.5.1/js/buttons.print.js')!!}
        {!!Html::script('plugins/datatables/Buttons-1.5.1/js/buttons.colVis.js')!!}
        


        <!-- END DATATABLEs PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        {!!Html::script('plugins/moment.min.js')!!}
        {!!Html::script('plugins/counterup/jquery.waypoints.min.js')!!}
        {!!Html::script('plugins/counterup/jquery.counterup.min.js')!!}
        {!!Html::script('plugins/morris/morris.min.js')!!}
        {!!Html::script('plugins/morris/raphael-min.js')!!}

        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        {!!Html::script('js/scripts/app.min.js')!!}
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        {!!Html::script('js/scripts/dashboard.min.js')!!}
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        {!!Html::script('js/scripts/layout.min.js')!!}
        {!!Html::script('js/scripts/demo.min.js')!!}
        {!!Html::script('js/scripts/quick-sidebar.min.js')!!}
        {!!Html::script('js/scripts/quick-nav.min.js')!!}
        @yield('javascripts')
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function ()
            {
                $('#clickmewow').click(function ()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
        
        <script>
        function goBack() {
            window.history.back();
        }
        </script>
   
   
       
    </body>

</html>

