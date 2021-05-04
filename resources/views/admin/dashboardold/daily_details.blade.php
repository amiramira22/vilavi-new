@extends('layouts.admin.template')
@section('content')
<script type="text/javascript">
    $(function () {
        $("#datepicker1").datepicker({dateFormat: 'yy-mm-dd'});
        $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
    });

</script>


<div class="m-portlet m-portlet--tab">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-search m--font-danger"></i>
                </span>
                <h3 class="m-portlet__head-text m--font-danger" style="text-transform: uppercase">
                    Search
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    {!! Form::open(['url' => 'admin/dashboard/daily_details', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}

    <style>
        .m-form .m-form__actions {
            padding: 15px;
        }
        .m-form .m-form__group {
            margin-bottom: 10px;
            padding-top: 30px;
            padding-bottom: 30px;

        }

    </style>
    <div class="form-group m-form__group row">


        <label class="col-md-2 col-form-label">Start Date</label>
        <div class="col-md-4">
            {!! Form::text('start_date', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker1']) !!}

        </div>

        <label class="col-md-2 col-form-label">End Date</label>
        <div class="col-md-4">
            {!! Form::text('end_date', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker2']) !!}

        </div>
    </div>

    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-lg-8"></div>
                <div class="col-lg-4">
                    <input class="btn m-btn--pill m-btn--air btn-outline-danger" type="submit" value="Submit">
                    <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>















<style>

    .m-body .m-content {
        padding: 10px 80px;
    }
    .m-subheader {
        padding: 30px 30px 0 80px;
    }
</style>
<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    DAILY VISITS DETAILS BY FO<small></small>
                </h3>
            </div>			
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-section__content">
<!--            <style>
                .m-table.m-table--head-bg-brand thead th {
                    background: #a6a6a7 !important;
                    color: #fff;
                    border-bottom: 0;
                    border-top: 0;
                }
            </style>-->
            <div class="table-responsive">
                <table class="table m-table m-table--head-bg-{{env('tableColor')}}" id="">
                    <thead>
                        <tr>
                            <th>FO name</th>
                            <th>Visits</th>
                            <th>Target</th>
                            <th>%</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($daily_visits_details_by_fo as $key => $value) {
                            if (isset($value->daily))
                                $daily = $value->daily;
                            else
                                $daily = 0;
                            ?>
                            <tr>
                                <td><?php echo $key; ?></td>
                                <td><?php echo $daily; ?></td>
                                <td><?php echo $value->target; ?></td>
                                <td><?php if ($value->target != 0) echo number_format(($daily / $value->target) * 100, 2); ?></td>

                            </tr>
                            <?
                        }
                        ?>        
                    </tbody>
                </table>
            </div>
        </div>	
    </div>
</div>


<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    DAILY VISITS DETAILS BY CHANNEL<small></small>
                </h3>
            </div>			
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-section__content">
<!--            <style>
                .m-table.m-table--head-bg-brand thead th {
                    background: #a6a6a7 !important;
                    color: #fff;
                    border-bottom: 0;
                    border-top: 0;
                }
            </style>-->
            <div class="table-responsive">
                <table class="table m-table m-table--head-bg-{{env('tableColor')}}" id="">
                    <thead>
                        <tr>
                            <th>FO name</th>
                            <th>Visits</th>
                            <th>Target</th>
                            <th>%</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($daily_visits_details_by_channel as $key => $value) {
                            if (isset($value->daily))
                                $daily = $value->daily;
                            else
                                $daily = 0;
                            ?>
                            <tr>
                                <td><?php echo $key; ?></td>
                                <td><?php echo $daily; ?></td>
                                <td><?php echo $value->target; ?></td>
                                <td><?php if ($value->target != 0) echo number_format(($daily / $value->target) * 100, 2); ?></td>

                            </tr>
                            <?
                        }
                        ?>        
                    </tbody>
                </table>
            </div>
        </div>	
    </div>
</div>





@endsection