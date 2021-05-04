@extends('layouts.admin.template')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
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
            {!! Form::open(['url' => 'admin/outlet/postOutlet', 'method' => 'post', 'class' => 'm-form m-form--label-align-righ','enctype'=>'multipart/form-data']) !!} 

            <div class="m-portlet__body">
                <div class="col-xl-8 offset-xl-2">
                    <div class="m-form__section m-form__section--first">
                        {!! Form::hidden('id', $outlet->id) !!}
                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Code</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('code',$outlet->code, ['class' => 'form-control m-input', 'placeholder' => 'Code']) !!}
                                {!! $errors->first('code', '<small class="help-block">:message</small>') !!}

                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Name</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('name', $outlet->name, ['class' => 'form-control m-input', 'placeholder' => 'Name']) !!}
                                {!! $errors->first('name', '<small class="help-block">:message</small>') !!}

                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">State</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('state_id', $states , $outlet->outletState->name ,['class' => 'form-control ']) !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Zone</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('zone_id', $zones , $outlet->outletZone->name ,['class' => 'form-control ']) !!}
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Longitude</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('longitude', $outlet->longitude, ['class' => 'form-control m-input', 'placeholder' => 'Longitude']) !!}
                                {!! $errors->first('longitude', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>          

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Latitude</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('latitude', $outlet->latitude, ['class' => 'form-control m-input', 'placeholder' => 'Latitude']) !!}
                                {!! $errors->first('latitude', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Channel</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('channel_id', $channels , $outlet->outletChannel->name ,['class' => 'form-control ']) !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Sub Channel</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('sub_channel_id', $subChannels , $outlet->outletSubChannel->name ,['class' => 'form-control ']) !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Adresse</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('adress', $outlet->adress, ['class' => 'form-control m-input', 'placeholder' => 'Adresse']) !!}
                                {!! $errors->first('adress', '<small class="help-block">:message</small>') !!}

                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Phone Number</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('phone', $outlet->contact, ['class' => 'form-control m-input', 'placeholder' => 'Phone Number']) !!}
                                {!! $errors->first('phone', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Contact</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::text('contact', $outlet->contact_pdv, ['class' => 'form-control m-input', 'placeholder' => 'Contact']) !!}
                                {!! $errors->first('contact', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Field Officiers</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('fo_id', $users , $outlet->outletUser->name ,['class' => 'form-control ']) !!}
                            </div>
                        </div>
                        <?php
                        $timestamp = strtotime('next Sunday');
                        $days = array();
                        for ($i = 0; $i < 7; $i++) {
                            $days[strftime('%A', $timestamp)] = strftime('%A', $timestamp);
                            $timestamp = strtotime('+1 day', $timestamp);
                        }
                        ?>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Visit Day</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('visit_day[]', $days , $visit_days ,['class' => 'form-control','id'=>'visit_day','multiple']) !!}
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label">Delivery Day</label>
                            <div class="col-xl-9 col-lg-9">
                                {!! Form::select('delivery_day', $days , null ,['class' => 'form-control','id'=>'']) !!}
                            </div>
                        </div>
                        <div class="form-group m-form__group row m-form__group row">
                            <label class="col-xl-2 col-lg-2 col-form-label" for="exampleInputEmail1">Photo </label>
                            <div class="col-xl-9 col-lg-9 custom-file">
                                <input type="file" name="photo" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <br>
                        <br>

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
</div>

<script>
$(document).ready(function () {
    $('#visit_day').multiselect({
        nonSelectedText: 'Select Visit Day',

        buttonWidth: '100%'
    });
});
</script>
@endsection