@extends('layouts.admin.template')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .m-form .m-form__section {
        margin: 40px 0 40px 40px;
    }
    .table {
        width: 100%;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
        background-color: rgba(0,0,0,0);
    }
    .m-table.m-table--head-separator-danger thead th {
        border-top: 0;
        border-bottom: 1px solid #c1c1c7;
    }
    .col-lg-6 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 0px !important;
        padding-left: 0px !important;
    }
    .col-lg-2{
        margin-right: 0px !important;
    }

    .m-card-profile .m-card-profile__details .m-card-profile__name {
        display: block;
        padding: 0 0 0 0;
        font-size: 1.2rem;
        font-weight: 500;
    }
</style>
<!--{{$users}}-->
@foreach($users as $user)
<div class="row">
    <!--<div class="col-lg-1"></div>-->
    <div class="col-lg-2">
        <!--m-portlet--full-height-->
        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="m-card-profile">
                    <div class="m-card-profile__title m--hide">
                        @lang('project.YOUR_PROFILE')
                    </div>


                    <div class="m-card-profile__pic">
                        <div class="m-card-profile__pic-wrapper">
                            @if (isset($user->photos))
                            <img src="https://hcm.capesolution.tn/uploads/users/{{$user->photos}}" alt="" width="110" height="110">
                            @else 
                            <img src="{{ asset('users/introuvable.png') }}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="m-card-profile__details">
                        <span class="m-card-profile__name">{{$user->name}}</span>
                        <!--<a href="" class="m-card-profile__email m-link">{{$user->email}}</a>-->
                    </div>
                </div>	
            </div>
        </div>			
    </div>	


    <div class="col-lg-10">
        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">

            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                        <li class="nav-item m-tabs__item" id="profile_<?php echo $user->id; ?>">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#update_profile_tab_<?php echo $user->id; ?>" role="tab">
                                <i class="flaticon-share m--hide"></i>
                                Update Profile
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item" id="routing_<?php echo $user->id; ?>">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#show_routing_tab_<?php echo $user->id; ?>" role="tab">
                                Show Routing
                            </a>
                        </li>
                        <script type="text/javascript">
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                            $("#routing_<?php echo $user->id; ?>").click(function () {

                                $('#show_routing_tab_<?php echo $user->id; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/plus-loader.gif'); ?>" class="img-responsive img-center" /></div>');
                                jQuery.ajax({
                                    url: '<?= route('admin.fo_report.load_fo_routing') ?>',
                                    data: {_token: CSRF_TOKEN, user_id: "<?php echo $user->id; ?>"},
                                    type: "POST",
                                    success: function (data) {
                                        $('#show_routing_tab_<?php echo $user->id; ?>').html(data);

                                    }
                                });
                            });
                        </script>

                    </ul>
                </div>

                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item m-portlet__nav-item--last">
                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                    <i class="fas fa-cog"></i>
                                </a>

                            </div>						
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="update_profile_tab_<?php echo $user->id; ?>">
                    <!--begin::Form-->	
                    {!! Form::model($user, ['route' => ['admin.user.update', $user->id], 'method' => 'put', 'class' => 'm-form m-form--label-align-righ', 'enctype' => 'multipart/form-data']) !!}	
                    <!--{!! Form::open(['url' => 'admin/user/update', 'method' => 'post', 'class' => 'm-form m-form--label-align-righ', 'enctype' => 'multipart/form-data']) !!}-->	

                    <div class="m-portlet__body">	
                        <div class="m-form__section m-form__section--first">	

                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label">Name</label>
                                <div class="col-lg-6">
                                    {!! Form::text('name',$user->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                                    {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label">Age</label>
                                <div class="col-lg-6">
                                    {!! Form::text('age', $user->age, ['class' => 'form-control', 'placeholder' => 'Age']) !!}
                                    {!! $errors->first('age', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label">Zone</label>
                                <div class="col-lg-6">
                                    {!! Form::text('zone', $user->zone, ['class' => 'form-control', 'placeholder' => 'Zone']) !!}
                                    {!! $errors->first('zone', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label">Tel</label>
                                <div class="col-lg-6">
                                    {!! Form::number('tel',$user->tel,['class' => 'form-control', 'placeholder' => 'Telephone']) !!}
                                    {!! $errors->first('tel', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>


                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label">Integration date</label>
                                <div class="col-lg-6">
                                    {!!  Form::text('integration_date',$user->integration_date, ['class' => 'form-control']) !!}
                                    {!! $errors->first('integration_date', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Study level</label>
                                <div class="col-lg-6">
                                    {!!  Form::text('study_level',$user->niveau, ['class' => 'form-control']) !!}
                                    {!! $errors->first('study_level', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label" for="exampleInputEmail1">Photo </label>
                                <div class="col-lg-6 custom-file">
                                    <input type="file" name="photos" class="custom-file-input" id="customFile<?php echo $user->id; ?>">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-8"></div>
                                <div class="col-lg-4">
                                    {!! Form::submit('Submit', ['class' => 'btn m-btn--pill m-btn--air btn-outline-danger']) !!}
                                    <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <!--end::Form-->

                </div>
                <div class="tab-pane " id="show_routing_tab_<?php echo $user->id; ?>">

                </div>
            </div>
        </div>
    </div>
</div>
@endforeach 

@endsection