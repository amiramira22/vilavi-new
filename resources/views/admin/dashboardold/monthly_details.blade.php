@extends('layouts.admin.template')
@section('content')
<script type="text/javascript">

    $(function () {
        $("#datepicker_m1").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'MM yy',
            altField: '#datepicker_m1_alt',
            altFormat: 'yy-mm-dd',
            onClose: function (dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            },
        });
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
    {!! Form::open(['url' => 'admin/dashboard/monthly_details', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}

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


        <label class="col-md-2 col-form-label">Month</label>
        <div class="col-md-4">

            {!! Form::text('start_date', format_qmw_date('month', $date), ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_m1']) !!}
            {!! Form::hidden('start_date_m', $date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker_m1_alt']) !!}

        </div>
        <label class="col-md-2 col-form-label"></label>
        <div class="col-md-4">

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
                    DAILY VISITS DETAILS BY FO<small>{{reverse_format($date)}}</small>
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
                        foreach ($monthly_visits_details as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['fo_name']; ?></td>
                                <td><?php echo $row['nb_visits']; ?></td>
                                <td><?php echo $row['target']; ?></td>
                                <td><?php if ($row['target'] != 0) echo number_format(($row['nb_visits'] / $row['target']) * 100, 2); ?></td>

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