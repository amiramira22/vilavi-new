@extends('layouts.client.template')
@section('content')
<div class="portlet light portlet-fit ">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-red"></i>
            <span class="caption-subject font-red bold uppercase">{{$subTitle}}</span>
        </div>
    </div>
    <div class="portlet-body form">
        {!! Form::open(['url' => 'admin/outlet/store', 'method' => 'post', 'class' => 'form-horizontal']) !!}	
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-3"> Code <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'Code']) !!}
                    {!! $errors->first('code', '<small class="help-block">:message</small>') !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3"> Name <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                    {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3"> Promoter <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!!  Form::select('promoter',array(0=>'No',1=>'Yes') , null , ['class' => 'form-control']) !!}
                    {!! $errors->first('promoter', '<small class="help-block">:message</small>') !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Promoter Name <span class="required">
                         </span>
                </label>
                <div class="col-md-6">
                    {!! Form::select('promoter_id', $promoters , null ,['class' => 'form-control']) !!}
                    {!! $errors->first('promoter_id', '<small class="help-block">:message</small>') !!}
                </div>
            </div>

           
        <div class="form-group">
                <label class="control-label col-md-3"> Adresse <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!! Form::text('adress', null, ['class' => 'form-control', 'placeholder' => 'Adresse']) !!}
                    {!! $errors->first('adress', '<small class="help-block">:message</small>') !!}
                </div>
            </div>
          
            <div class="form-group">
                <label class="control-label col-md-3"> Phone Number <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone Number']) !!}
                    {!! $errors->first('phone', '<small class="help-block">:message</small>') !!}
                </div>
            </div>

        </div>
        <div class="form-group">
                <label class="control-label col-md-3"> Antenna <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!!  Form::select('antenna',array(0=>'No',1=>'Yes'),null, ['class' => 'form-control']) !!}
                    {!! $errors->first('antenna', '<small class="help-block">:message</small>') !!}
                </div>
            </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    {!! Form::submit('Save', ['class' => 'btn btn-circle red btn-outline']) !!}
                    <button type="button" class="btn btn-circle black btn-outline">Cancel</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <!-- END FORM-->
    </div>
</div>

</div>
</div>		


@endsection