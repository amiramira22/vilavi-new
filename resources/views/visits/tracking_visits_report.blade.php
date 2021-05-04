@extends('layouts.admin.template')
@section('content')

<script>
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
                <h3 class="m-portlet__head-text m--font-danger" style="">
                    @lang('project.SEARCH')
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    {!! Form::open(['url' => 'visit/trackingVisitsReport', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">

            <label for="example-text-input" class="col-2 col-form-label">@lang('project.start_date')</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                <div class="input-group date">
                    {!! Form::text('start_date', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker1']) !!}
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
            </div>

            <label for="example-text-input" class="col-2 col-form-label">@lang('project.end_date')</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                <div class="input-group date">
                    {!! Form::text('end_date', $end_date, ['class' => 'form-control m-input', 'placeholder' => 'End Date','id'=>'datepicker2']) !!}
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="m-portlet__body">
        <div class="form-group m-form__group row">
            <label class="col-2 col-form-label">@lang('project.MERCHANDISER')s</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                {!! Form::select('fo_id', $users , $fo_id ,['class' => 'form-control m-select2','id'=>'m_select2_1']) !!}
            </div>

        </div>
    </div>


    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-lg-8"></div>
                <div class="col-lg-4">
                    <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-danger"> @lang('project.SUBMIT')</button>
                    <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary"> @lang('project.CANCEL')</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>


<div class="m-portlet m-portlet--tab">
    <div class="m-portlet__head">
       
    </div>
<div class="m-portlet__body">
    <?php //dd($visited_outlets); ?>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped- table-bordered table-hover table-checkable"  id="">
                <h3>Visited Outlets (<?php echo count($visited_outlets); ?>) </h3>
                <thead>
                    <tr>
                        <th> Outlet </th>
                        <th> Fo </th>
                        <th> State </th>
                        <th> Zone</th>
                        <th> Visit Date </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($visited_outlets as $v) { ?>
                        <tr>
                            <td><?php echo $v->outlet_name; ?></td>
                            <td><?php echo $v->hfo; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td><?php echo $v->zone_name; ?></td>
                            <td><?php echo reverse_format($v->date); ?></td>
                        </tr>

                    <?php } // end foreach  ?>
                </tbody>
            </table>
        </div> <!-- end col-md-6 -->


        <div class="col-md-6">
            <table class="table table-striped- table-bordered table-hover table-checkable"  id="">
                <h3>unvisited Outlets (<?php echo count($unvisited_outlets); ?>)</h3>
                <thead>
                    <tr>
                        <th> Outlet </th>
                        <th> Fo </th>
                        <th> State </th>
                        <th> Zone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($unvisited_outlets as $unv) { ?>
                        <tr>
                            <td><?php echo $unv->outlet_name; ?></td>
                            <td><?php echo $unv->hfo; ?></td>
                            <td><?php echo $unv->state_name; ?></td>
                            <td><?php echo $unv->zone_name; ?></td>
                        </tr>

                    <?php } // end foreach  ?>
                </tbody>
            </table>
        </div> <!-- end col-md-6 -->
    </div>  <!-- end row 2-->

</div>
</div>
<script>

    var Select2 = {
        init: function () {
            $("#m_select2_1, #m_select2_1_validate").select2({
                placeholder: "Select a FO"
            })
        }
    };
    jQuery(document).ready(function () {
        Select2.init()
    });

</script>
@endsection