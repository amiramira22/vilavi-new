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
        {!! Form::open(['url' => 'visit/orderReport', 'method' => 'post',
        'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">

                <label for="example-text-input" class="col-1 col-form-label">@lang('project.start_date')</label>
                <div class="col-lg-3 col-md-9 col-sm-12">
                    <div class="input-group date">
                        {!! Form::text('start_date', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker1']) !!}
                        <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-check-o"></i>
                        </span>
                        </div>
                    </div>
                </div>

                <label for="example-text-input" class="col-1 col-form-label">@lang('project.end_date')</label>
                <div class="col-lg-3 col-md-9 col-sm-12">
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
                <label class="col-lg-1 col-form-label">@lang('project.ZONE')</label>
                <div class="col-lg-3 col-md-9 col-sm-12">
                    {!! Form::select('selected_zone_ids[]', $zones_of_select ,null,['class' =>
                    'form-control m-select2','id'=>'m_select_zone','multiple']) !!}
                </div>

                <label class="col-1 col-form-label">@lang('project.MERCHANDISER')s</label>
                <div class="col-lg-3 col-md-9 col-sm-12">
                    {!! Form::select('selected_fo_ids[]', $users , null ,
               ['class' => 'form-control m-select2','id'=>'m_select_fo','multiple']) !!}
                </div>

                <?php if(request()->session()->get('connected_user_acces') != 'Responsible' ) { ?>
                <label class="col-lg-1 col-form-label">Resposible's Order</label>
                <div class="col-lg-3 col-md-9 col-sm-12">

                    {!! Form::select('responsible_order_selected', $responsible_order_type ,null,['class' =>
                    'form-control m-select2','id'=>'m_select_orderType']) !!}
                </div>
                <?php } ?>
            </div>
        </div>




        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <div class="row">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-danger">
                            @lang('project.SUBMIT')</button>
                        <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary">
                            @lang('project.CANCEL')</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    @include('visits.list_of_orderVisit')

    <script>
        var Select2 = {
            init: function () {
                $("#m_select2_1, #m_select2_1_validate,#m_select_zone,#m_select_fo,#m_select_orderType").select2({
                    placeholder: "Please Select"
                })
            }
        };
        jQuery(document).ready(function () {
            Select2.init()
        });

    </script>
@endsection