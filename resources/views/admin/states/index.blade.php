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
                    <a href="{{ route('admin.state.create') }}" class="btn btn-outline-primary m-btn m-btn--custom m-btn--icon m-btn--outline-2x m-btn--pill m-btn--air">
                        <span>
                            <i class="fas fa-cart-plus"></i>
                            <span>New State</span>
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
        <table class="table table-striped- table-bordered table-hover table-checkable"  id="state_tab">
            <thead>
                <tr>
                    <th> Code </th>
                    <th> State </th>
                    <th> Zone </th>
                    <th> Status </th>
                    <th> Actions </th>
                </tr>
            </thead>

        </table>
    </div>
    </div>
</div>





<script>
    $(document).ready(function () {
        var table = $('#state_tab').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 20,

            ajax: {
                "url": "<?= route('admin.state.getStates') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?= csrf_token() ?>"}
            },
            columns: [
                {"data": "code"},
                {"data": "state"},
                {"data": "zone"},
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
