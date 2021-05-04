@extends('layouts.admin.template')
@section('content')



<div class="m-portlet m-portlet--full-height">
    <!--begin: Portlet Head-->
    <div class="m-portlet__head">

        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-add-circular-button m--font-danger"></i>
                </span>
                <h3 class="m-portlet__head-text m--font-danger">
                    @if(isset($subTitle)) {{ $subTitle }}  @endif
                </h3>
            </div>			
        </div>


    </div>
    <!--end: Portlet Head-->
    <!--begin: Form Wizard-->
    <div class="m-wizard">
        <!--begin: Message container -->

        <!--begin: Form Wizard Form-->
        <div class="m-wizard__form">
            <!--
                1) Use m-form--label-align-left class to alight the form input lables to the right
                2) Use m-form--state class to highlight input control borders on form validation
            -->

            {!! Form::open(['url' => 'admin/brand/postBrand', 'method' => 'post', 'class' => 'm-form m-form--label-align-left- m-form--state-', 'enctype' => 'multipart/form-data']) !!}
            <!--begin: Form Body -->
            <div class="m-portlet__body">
                <!--begin: Form Wizard Step 1-->
                <div class="m-wizard__form-step m-wizard__form-step--current" >
                    <div class="row">
                        <div class="col-xl-8 offset-xl-2">
                            <div class="m-form__section m-form__section--first">
                                <div class="form-group m-form__group row">
                                    <label class="col-xl-2 col-lg-2 col-form-label">* Code:</label>
                                    <div class="col-xl-9 col-lg-9">
                                        {!! Form::text('code', null, ['class' => 'form-control m-input', 'placeholder' => 'Code']) !!}
                                        {!! $errors->first('code', '<small class="m--font-danger">:message</small>') !!}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-xl-2 col-lg-2 col-form-label">* Name:</label>
                                    <div class="col-xl-9 col-lg-9">
                                        {!! Form::text('name', null, ['class' => 'form-control m-input', 'placeholder' => 'Name']) !!}
                                        {!! $errors->first('name', '<small class="m--font-danger">:message</small>') !!}
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-xl-2 col-lg-2 col-form-label">* Color:</label>
                                    <div class="col-xl-9 col-lg-9">
                                        {!! Form::color('color', null, ['class' => 'form-control m-input', 'placeholder' => 'Color']) !!}
                                        {!! $errors->first('color', '<small class="m--font-danger">:message</small>') !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--end: Form Body -->
            <!--begin: Form Actions -->
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
            <!--end: Form Actions -->
            </form>
        </div>
        <!--end: Form Wizard Form-->
    </div>
    <!--end: Form Wizard-->
</div>
@endsection