@extends('layouts.admin.template')
@section('content')



<script>
    $(function () {

        $("#datepicker1").datepicker({dateFormat: 'yy-mm-dd'});
        $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<style>
    .m-form.m-form--fit .m-form__group {
        padding-left: 0px;
        padding-right: 100px;
    }

</style>
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
    {!! Form::open(['url' => 'admin/fo_report/gps_monitoring', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">

            <label class="col-2 col-form-label">   @lang('project.MERCHANDISER')s</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                {!! Form::select('fo_id', $fos , $fo_id ,['class' => 'form-control m-select2','id'=>'m_select2_1']) !!}
            </div>


            <label for="example-text-input" class="col-2 col-form-label">Day</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                <div class="input-group date">
                    {!! Form::text('date', $date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker1']) !!}

                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
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
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">

                <h3 class="m-portlet__head-text m--font-danger">
                    @lang('project.GPS_MONITORING')
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <form class="form-inline m--margin-bottom-10" action="#">
            <input type="button" id="m_gmap_7_btn" class="btn btn-success" value="Start Routing" />
        </form>
        <div id="m_gmap_7" style="height:300px;">
        </div>
        <ol id="m_gmap_7_routes">
        </ol>
    </div>
</div>

<script>
    var Select2 = {
        init: function () {
            $("#m_select2_1, #m_select2_2,#m_select2_3").select2({
                placeholder: "Select a FO"
            })
        }
    };
    jQuery(document).ready(function () {
        Select2.init()
    });



</script>




@endsection