@extends('layouts.admin.template')

@section('content')

<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">

        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-list-3 m--font-danger"></i>
                </span>
                <h3 class="m-portlet__head-text m--font-danger">
                    @if(isset($subTitle)) {{ $subTitle }}  @endif
                </h3>
            </div>			
        </div>

        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="{{ route('admin.product_group.create') }}" class="btn btn-outline-primary m-btn m-btn--custom m-btn--icon m-btn--outline-2x m-btn--pill m-btn--air">
                        <span>
                            <i class="fas fa-cart-plus"></i>
                              <span> @lang('project.NEW')  @lang('project.PRODUCT_GROUP')</span>
                        </span>
                    </a>
                </li>
                <li class="m-portlet__nav-item"></li>

            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <!--begin: Datatable -->
         <div class="table-responsive">
        <table class="table table-striped- table-bordered table-hover table-checkable"  id="product_group_tab">
            <thead>
                <tr>
                    <th> Code </th>
                    <th> Product Group </th>
                    <th> Cluster </th>
                    <th> Status </th>
                    <th> Actions </th>
                </tr>
            </thead>

        </table>
    </div>
    </div>
</div>

<script>
//    var DatatablesBasicHeaders = {
//        init: function () {
//            $("#m_table_1").DataTable({
//                responsive: !0,
//                columnDefs: [{
//                        targets: -1,
//                        title: "Actions",
//                        orderable: !1,
//                        render: function (a, e, t, n) {
//                            return '\n<span class="dropdown">\n<a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n  <i class="fas fa-ellipsis-h"></i>\n</a>\n<div class="dropdown-menu dropdown-menu-right">\n    <a class="dropdown-item" href="#"><i class="fas fa-edit"></i> Edit Details</a>\n    <a class="dropdown-item" href="#"><i class="fas fa-leaf"></i> Update Status</a>\n    <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Generate Report</a>\n</div>\n</span>\n<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n  <i class="fas fa-edit"></i>\n</a>'
//                        }
//                    }]
//            })
//        }
//    };
//    $(document).ready(function () {
//        DatatablesBasicHeaders.init()
//    });

</script>




<script>
    $(document).ready(function () {
        var table = $('#product_group_tab').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 20,

            ajax: {
                "url": "<?= route('admin.product_group.getProductGroups') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?= csrf_token() ?>"}
            },
            columns: [
                {"data": "code"},
                {"data": "product_group"},
                {"data": "cluster"},
                {"data": "status", "searchable": false},
                {"data": "action", "searchable": false, "orderable": false}
            ],

            buttons: {
                buttons: [{
                        extend: 'copy',
                        text: 'Copy',
                        title: $('h1').text(),
                        exportOptions: {
                            columns: ':not(.no-print)'
                        },
                        footer: true
                    }, {
                        extend: 'excel',
                        text: 'Excel',
                        title: $('h1').text(),
                        exportOptions: {
                            columns: ':not(.no-print)'
                        },
                        footer: true
                    }, {
                        extend: 'csv',
                        text: 'Csv',
                        title: $('h1').text(),
                        exportOptions: {
                            columns: ':not(.no-print)'
                        },
                        footer: true
                    }, {
                        extend: 'pdf',
                        text: 'Pdf',
                        title: $('h1').text(),
                        exportOptions: {
                            columns: ':not(.no-print)'
                        },
                        footer: true
                    }, {
                        extend: 'print',
                        text: 'Print',
                        title: $('h1').text(),
                        exportOptions: {
                            columns: ':not(.no-print)'
                        },
                        footer: true,
                        autoPrint: true
                    }],
                dom: {
                    container: {
                        className: 'dt-buttons'
                    },
                    button: {
                        className: 'btn btn-primary'
                    }
                }
            }
        });
        table.buttons().container()
                .appendTo('#example_wrapper .col-sm-6:eq(0)');
    });

</script>

@endsection
