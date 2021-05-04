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
    {!! Form::open(['url' => 'admin/visit', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">
            <!--            {{$start_date, $end_date ,$visit_type ,$fo_id}}-->
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

            <label class="col-2 col-form-label">@lang('project.VISIT_TYPE')</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
<!--                <select class="form-control " name="visit_type" value="{{$visit_type}}">
                    <option value="-1">All Visits</option>
                    <option value="0">Daily</option>
                    <option value="1">Shelf</option>
                    <option value="2">Price</option>
                </select>-->
                {!! Form::select('visit_type', $visit_types , $visit_type ,['class' => 'form-control ','id'=>'visit_type']) !!}

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


@include('admin.visits.list_of_visits')

<script>
//    var BootstrapDatepicker = function () {
//
//        return {
//            init: function () {
//                $("#m_datepicker_1_modal").datepicker({
//                    format: "yyyy-mm-dd",
//                    todayHighlight: !0,
//                    orientation: "bottom left",
//
//                }), $("#m_datepicker_2_modal").datepicker({
//                    format: "yyyy-mm-dd",
//                    todayHighlight: !0,
//                    orientation: "bottom left",
//
//                })
//
//            }
//        }
//    }();
//    jQuery(document).ready(function () {
//        BootstrapDatepicker.init()
//    });




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