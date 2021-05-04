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

    </div>
    <div class="m-portlet__body">
        <!--begin: Datatable -->
        <div class="table-responsive">
            <table class="table table-striped- table-bordered table-hover table-checkable"  id="outlet_tab_new">
                <thead>
                    <tr>
                        <th> Created </th>
                        <th> Code </th>
                        <th> Name </th>
                        <th> Channel </th>
                        <th> Sub channel </th>
                        <th> State </th>
                        <th> Zone </th>
                        <th> FO Name </th>
                        <th> Status</th>
                        <th> Ha Products </th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        var table = $('#outlet_tab_new').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 20,

            ajax: {
                "url": "<?= route('admin.outlet.getOutletsForHaProducts') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?= csrf_token() ?>"}
            },
            columns: [
                {"data": "created", "searchable": false, },
                {"data": "code"},
                {"data": "outlet"},
                {"data": "channel"},
                {"data": "sub_channel"},
                {"data": "state"},
                {"data": "zone"},
                {"data": "fo_name"},
                {"data": "status"},
                {"data": "ha_products", "searchable": false, "orderable": false}
            ],
            order: [[0, "desc"]]

        });

    });

</script>


@endsection