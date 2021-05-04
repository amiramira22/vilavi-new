 <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> {{ date('Y')}} &copy; Beesoft.
                <a href="http://beesoft.tn" title="Beesoft" target="_blank">Survey System</a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        {!!Html::script('plugins/bootstrap/js/bootstrap.min.js')!!}


        {!!Html::script('plugins/js.cookie.min.js')!!}
        {!!Html::script('plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')!!}
        {!!Html::script('plugins/jquery-slimscroll/jquery.slimscroll.min.js')!!}
        {!!Html::script('plugins/jquery.blockui.min.js')!!}
        {!!Html::script('plugins/uniform/jquery.uniform.min.js')!!}
        {!!Html::script('plugins/bootstrap-switch/js/bootstrap-switch.min.js')!!}
        <!-- END CORE PLUGINS -->
        {!!Html::script('plugins/bootstrap-multiselect/js/bootstrap-multiselect.js')!!}
        
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

        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        {!!Html::script('js/app.min.js')!!}
        <!-- END THEME GLOBAL SCRIPTS -->



        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        {!!Html::script('js/layout.min.js')!!}
        {!!Html::script('js/demo.min.js')!!}
        {!!Html::script('js/quick-sidebar.min.js')!!}

        <!-- END  -->
        <script>
            var ComponentsBootstrapMultiselect = function () {
                return{
                    init: function () {
                        $(".mt-multiselect").each(function () {
                            var t,
                                    a = $(this).attr("class"),
                                    i = !!$(this).data("clickable-groups") && $(this).data("clickable-groups"),
                                    l = !!$(this).data("collapse-groups") && $(this).data("collapse-groups"),
                                    o = !!$(this).data("drop-right") && $(this).data("drop-right"),
                                    e = (!!$(this).data("drop-up") && $(this).data("drop-up"), !!$(this).data("select-all") && $(this).data("select-all")),
                                    s = $(this).data("width") ? $(this).data("width") : "", n = $(this).data("height") ? $(this).data("height") : "", d = !!$(this).data("filter") && $(this).data("filter"), h = function (t, a, i) {
                                alert("Changed option " + $(t).val() + ".")
                            }, r = function (t) {
                                alert("Dropdown shown.")
                            }, c = function (t) {
                                alert("Dropdown Hidden.")
                            }, p = 1 == $(this).data("action-onchange") ? h : "", u = 1 == $(this).data("action-dropdownshow") ? r : "", b = 1 == $(this).data("action-dropdownhide") ? c : "";
                            t = $(this).attr("multiple") ? '<li class="mt-checkbox-list"><a href="javascript:void(0);"><label class="mt-checkbox"> <span></span></label></a></li>' : '<li><a href="javascript:void(0);"><label></label></a></li>', $(this).multiselect({enableClickableOptGroups: i, enableCollapsibleOptGroups: l, disableIfEmpty: !0, enableFiltering: d, includeSelectAllOption: e, dropRight: o, buttonWidth: s, maxHeight: n, onChange: p, onDropdownShow: u, onDropdownHide: b, buttonClass: a})
                        })
                    }}}();
            jQuery(document).ready(function () {
                ComponentsBootstrapMultiselect.init()
            });
        </script>
