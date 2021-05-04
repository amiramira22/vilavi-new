@extends('layouts.admin.template')
@section('content')

<!--<style>
    .m-portlet .m-portlet__body {
        padding: 2.2rem 15rem !important;
    }

</style>-->


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
            {!! Form::model($user, ['route' => ['admin.user.update', $user->id], 'method' => 'put', 'class' => 'm-form m-form--label-align-righ', 'enctype' => 'multipart/form-data']) !!}	
            <!--{!! Form::open(['url' => 'admin/user/update', 'method' => 'post', 'class' => 'm-form m-form--label-align-righ', 'enctype' => 'multipart/form-data']) !!}-->	

            <div class="m-portlet__body">
                <div class="col-xl-8 offset-xl-2">
                    <div class="m-form__section m-form__section--first">	

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Name</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('name',$user->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                                {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">User Name</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('username', $user->username, ['class' => 'form-control', 'placeholder' => 'Username']) !!}
                                {!! $errors->first('username', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Email</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>



                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Password</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                                {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Confirm Password</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Role</label>
                            <div class="col-xl-9 col-lg-9">
                                {!!  Form::select('access',$roles,$user->access, ['class' => 'form-control']) !!}
                                {!! $errors->first('access', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>



                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label" for="exampleInputEmail1">Photo </label>
                            <div class="col-xl-9 col-lg-9 custom-file">
                                <input type="file" name="photo" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
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