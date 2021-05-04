@extends('layouts.admin.template')

@section('content')
<style>
    .m-body .m-content {
        padding: 10px 0px !important;
    }
    .m-subheader {
        padding: 30px 0px 0 0px !important;
    }
</style>

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
                    <a href="{{ route('admin.outlet.create') }}" class="btn btn-outline-primary m-btn m-btn--custom m-btn--icon m-btn--outline-2x m-btn--pill m-btn--air">
                        <span>
                            <i class="fas fa-cart-plus"></i>
                                  @lang('project.OUTLET')
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
            <table class="table table-striped- table-bordered table-hover table-checkable"  id="outlet_tab">
                <thead>
                    <tr>
                        <th> Image </th>
                        <th> Created </th>
                        <th> Code </th>
                        <th> Name </th>
                        <th> Channel </th>
                        <th> Sub channel </th>
                        <th> State </th>
                        <th> Zone </th>
                        <th> FO Name </th>
                        <th> Adresse </th>
                        <th> Status</th>
                        <th> Action </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var table = $('#outlet_tab').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 20,

            ajax: {
                "url": "<?= route('admin.outlet.getOutlets') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?= csrf_token() ?>"}
            },
            columns: [
                {"data": "image", "searchable": false},
                {"data": "created", "searchable": false, },
                {"data": "code"},
                {"data": "outlet"},
                {"data": "channel"},
                {"data": "sub_channel"},
                {"data": "state"},
                {"data": "zone"},
                {"data": "fo_name"},
                {"data": "adresse"},
                {"data": "status"},
                {"data": "action", "searchable": false, "orderable": false}
            ],
            order: [[0, "desc"]],
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

