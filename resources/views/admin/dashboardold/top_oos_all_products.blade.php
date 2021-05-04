@extends('layouts.admin.template')
@section('content')
<style>

    .m-body .m-content {
        padding: 10px 100px;
    }
</style>
<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    OOS Products <small>{{reverse_format($date)}}</small>
                </h3>
            </div>			
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-section__content">
            <table class="table m-table m-table--head-bg-{{env('tableColor')}}">
                <thead>
                    <tr>
                        <th style=" width: 90px !important;">#</th>
                        <th style=" width: 1250px !important;">Product</th>
                        <th style=" width: 90px !important;">Oos %</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($products as $p) {
                        ?>
                        <tr>
                            <th scope="row" style=" width: 90px !important;">  {{$i}}</th>
                            <td style=" width: 125px !important;"><?php echo $p['product_name']; ?></td>
                            <td style=" width: 90px !important;"><?php echo number_format(($p['oos']), 2); ?></td>
                        </tr>

                        <?php
                        $i++;
                    }
                    ?>

                </tbody>
            </table>
        </div>	
    </div>
</div>

@endsection