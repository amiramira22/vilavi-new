@extends('layouts.admin.template')
@section('content')
<script>
    var BootstrapDatepicker = function () {

        return {
            init: function () {
                $("#m_datepicker_1_modal").datepicker({
                    format: "yyyy-mm-dd",
                    todayHighlight: !0,
                    orientation: "bottom left",

                })
            }
        }
    }();
    jQuery(document).ready(function () {
        BootstrapDatepicker.init()
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">

                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-edit-1 m--font-danger"></i>
                        </span>
                        <h3 class="m-portlet__head-text m--font-danger uppercase">
                            @if(isset($subTitle)) {{ $subTitle }}  @endif
                        </h3>
                    </div>			
                </div>


            </div>
            <!--begin::Form-->
            {!! Form::open(['url' => 'admin/visit/postVisit', 'method' => 'post', 'class' => 'm-form m-form--label-align-righ']) !!}	

            <div class="m-portlet__body">
                <div class="col-xl-8 offset-xl-2">
                    <div class="m-form__section m-form__section--first">		
                        {!! Form::hidden('id', $visit->id) !!}

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">@lang('project.MERCHANDISERS')</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('fo_id', $users , $visit->user->name ,['class' => 'form-control ']) !!}

                            </div>
                        </div>


                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label"> @lang('project.OUTLET')</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('outlet_id', $outlets , $visit->outlet->name ,['class' => 'form-control ']) !!}

                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Date</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('date', $visit->date, ['class' => 'form-control m-input', 'placeholder' => 'Date','id'=>'m_datepicker_1_modal']) !!}
                                {!! $errors->first('date', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label"> @lang('project.REMARK')</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::textarea('remark', $visit->remark, ['class' => 'form-control m-input', 'placeholder' => 'Name']) !!}
                                {!! $errors->first('remark', '<small class="help-block">:message</small>') !!}
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
            {!! Form::close() !!}
            <!--end::Form-->
        </div>
        <!--end::Portlet-->

    </div>
</div>
@endsection