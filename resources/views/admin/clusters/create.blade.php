@extends('layouts.admin.template')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="m-portlet">
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
            <!--begin::Form-->
            {!! Form::open(['url' => 'admin/cluster/postCluster', 'method' => 'post', 'class' => 'm-form m-form--label-align-righ', 'enctype' => 'multipart/form-data']) !!}	

            <div class="m-portlet__body">
                <div class="col-xl-8 offset-xl-2">
                    <div class="m-form__section m-form__section--first">		

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Code</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('code', null, ['class' => 'form-control m-input', 'placeholder' => 'Code']) !!}
                                {!! $errors->first('code', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Name</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('name', null, ['class' => 'form-control m-input', 'placeholder' => 'Name']) !!}
                                {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>	

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Sub Category</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('sub_category_id', $subcategories , null ,['class' => 'form-control ']) !!}

                            </div>
                        </div>

                        <!--                    <div class="form-group m-form__group row">
                                                <label class="col-xl-2 col-lg-2 col-form-label">Photo</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="file" name="photos[]" class="form-control m-input" multiple />
                                                </div>
                                            </div>-->
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