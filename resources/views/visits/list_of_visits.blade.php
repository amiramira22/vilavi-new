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
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
    }

    @-webkit-keyframes blinker {  
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
    }

    @keyframes blinker {  
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
    }
    th, td{ text-align: center !important;  }

    .package-rating-detail {
        display: inline-flex !important;
        align-items: center !important;
        margin-top: 0.3em !important; // cosmetic
    margin-left: 1em !important; // cosmetic
    }
</style>

<div class="m-portlet m-portlet--tabs">



    <div class="m-portlet__head">
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--danger m-tabs-line--2x" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_1"
                       role="tab" aria-selected="true">
                        Visite Temps Réel
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
                        <table class="table table-striped- table-bordered table-hover table-checkable"  id="visit_tab">
                            <thead>
                                <tr>

                                    <th style="display:none;"></th>
                                    <th> Merch </th>
                                    <th> Outlet </th>
                                    <th> Channel </th>
                                    <th> Zone </th>
                                    <th> State </th>
                                    <th> Date </th>
                                    <th> Entry time </th>
                                    <th> Exit time </th>
                                    <th> OOS % </th>
                                    {{--<th> Shelf % </th>--}}
                                    <th>Branding</th>
                                    <th>Order</th>
                                    <th> Remark </th>
                                    <th style="white-space:nowrap !important;"> Actions </th>
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
            "order": [[0, "desc"]],
            ajax: {
                "url": "<?= route('visit.getVisits') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?= csrf_token() ?>",
                    start_date: "<?php echo $start_date; ?>",
                    end_date: "<?php echo $end_date; ?>",
                    visit_type: "<?php echo $visit_type; ?>",
                    fo_id: "<?php echo $fo_id; ?>"
                }

            },

            columns: [
                {"data": "id", "visible": false},
                {"data": "fo"},
                {"data": "outlet"},
                {"data": "channel"},
                {"data": "zone"},
                {"data": "state"},
                {"data": "date"},
                {"data": "entry_time"},
                {"data": "exit_time"},
                {"data": "oos"},
                {"data": "branding","searchable": false, "orderable": false},
                {"data": "order", "searchable": false, "orderable": false},
                // {"data": "shelf"},
                {"data": "remark", "orderable": false},
                {"data": "action", "searchable": false, "orderable": false}
            ]
        });

        console.log('<?php echo $start_date; ?>');
        console.log('<?php echo $fo_id; ?>');

        table.buttons().container()
                .appendTo('#example_wrapper .col-sm-6:eq(0)');



    });
</script>