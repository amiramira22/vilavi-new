<style>
    .blink_me {
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 1s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;

        -moz-animation-name: blinker;
        -moz-animation-duration: 1s;
        -moz-animation-timing-function: linear;
        -moz-animation-iteration-count: infinite;

        animation-name: blinker;
        animation-duration: 1s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    @-moz-keyframes blinker {
        0% {
            opacity: 1.0;
        }
        50% {
            opacity: 0.0;
        }
        100% {
            opacity: 1.0;
        }
    }

    @-webkit-keyframes blinker {
        0% {
            opacity: 1.0;
        }
        50% {
            opacity: 0.0;
        }
        100% {
            opacity: 1.0;
        }
    }

    @keyframes blinker {
        0% {
            opacity: 1.0;
        }
        50% {
            opacity: 0.0;
        }
        100% {
            opacity: 1.0;
        }
    }

    th, td {
        text-align: center !important;
    }

    .package-rating-detail {
        display: inline-flex !important;
        align-items: center !important;
        margin-top: 0.3em !important;
    / / cosmetic margin-left: 1 em !important;
    / / cosmetic
    }
</style>

<div class="m-portlet m-portlet--tabs">

    <div class="m-portlet__head">
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--danger m-tabs-line--2x" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_1"
                       role="tab" aria-selected="true">
                        Order Report
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="m-portlet__body">

        <div class="tab-content">
            <!--begin: Datatable -->
            <div class="tab-pane active show" id="m_tabs_1" role="tabpanel">
                <div class="content">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable"
                               id="visit_tab">
                            <thead>
                            <tr>
                                <th> Merch</th>
                                <th> Outlet</th>
                                <th> Channel</th>
                                <th> Zone</th>
                                <th> State</th>
                                <th> Date</th>
                                <th> OOS %</th>
                                <th style="white-space:nowrap !important;"> Report</th>
                                <th style="white-space:nowrap !important;"> Action</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane active show" id="m_tabs_2" role="tabpanel">
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        var table = $('#visit_tab').DataTable({
            processing: true,
            serverSide: true,
            "order": [[6, "desc"]],
            ajax: {
                "url": "<?= route('visit.getOrderVisits') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {
                    "_token": "<?= csrf_token() ?>",
                    start_date: "<?php echo $start_date; ?>",
                    end_date: "<?php echo $end_date; ?>",
                    responsible_order_selected: "<?php echo $responsible_order_selected; ?>",
                    order_type: "OrderNull",
                    zone_ids: JSON.stringify(<?php echo $json_zone_ids; ?>),
                    fo_ids: JSON.stringify(<?php echo $json_fo_ids; ?>)
                }
            },
            columns: [
                {"data": "fo"},
                {"data": "outlet"},
                {"data": "channel"},
                {"data": "zone"},
                {"data": "state"},
                {"data": "date"},
                {"data": "oos"},
                {"data": "report", "searchable": false, "orderable": false},
                {"data": "action", "searchable": false, "orderable": false}
            ]
        });


        table.buttons().container()
            .appendTo('#example_wrapper .col-sm-6:eq(0)');


    });
</script>


<!--begin::Modal-->
<div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header ">

                <h5 class="modal-title  m--font-danger" id="exampleModalLabel">
                    <i class="fa fa-plus m--font-danger"></i>
                    <span style="padding-left:10px;"></span>
                    New Order File
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times<i class="fas fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => 'visit/postOrderFile', 'method' => 'post',
                   'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off',
                    'enctype' => 'multipart/form-data']) !!}
                <input type="text" name="visit_id" id="visit_id" style="display: none;">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2">
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-xl-2 col-lg-2 col-form-label" for="exampleInputEmail1">File </label>
                                <div class="col-xl-9 col-lg-9 custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-danger">Submit</button>

                <button type="button" class=" btn m-btn--pill m-btn--air btn-outline-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
            </form>
        </div>

    </div>
</div>
<!--end::Modal-->

<div class="modal fade" id="m_modal_ShowOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header ">

                <h5 class="modal-title  m--font-danger" id="exampleModalLabel">
                    <i class="fa fa-plus m--font-danger"></i>
                    <span style="padding-left:10px;"></span>
                    Uploaded Order File
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times<i class="fas fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <img id="OrderPhoto" src="#" width="700px" height="500px">

            </div>
        </div>

    </div>
</div>

<script>
    function setVisitID(visit_id) {
        document.getElementById("visit_id").value = visit_id;
    }
</script>
<script>
     function setOrderPhoto(file_name) {
        console.log(file_name)
        $("#OrderPhoto").attr("src", "{{ asset('OrderResponsible/') }}" + "/"+file_name);
    }
</script>