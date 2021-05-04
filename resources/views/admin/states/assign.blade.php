
@extends('layouts.admin.template')
@section('content')



<?php 
//dd($outlets);
?>

<div class="portlet light portlet-fit ">
    <div class="portlet-title">
        <div class="caption">
            <i class="glyphicon glyphicon-retweet font-red"></i>
            <span class="caption-subject font-red bold uppercase"> {{$subTitle}} <i class="glyphicon glyphicon-arrow-right"></i> {{$outlet->name}} </span>
        </div>
    </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                 {!! Form::open(['url' => ['admin/outlet/assign',$outlet->id], 'method' => 'post', 'class' => 'form-horizontal']) !!}	
               
                <div class="form-body">




                    <div class="form-group">
                        <label  class="control-label col-md-3"> Promoter<span class="required">
                        * </span></label>
                        <div class="col-md-6">
                       
                    
                    {!! Form::select('promoter_id',$promoters,null,['class'=>'form-control']) !!}                  
                    {!! $errors->first('promoter_id', '<small class="help-block">:message</small>') !!}
                       
                        </div>
                    
                
            </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-5 col-md-9">
                            {!! Form::submit('Save', ['class' => 'btn btn-circle red btn-outline']) !!}
                            <button type="reset" class="btn  btn-circle  default ">Cancel</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                    <!-- END FORM-->
            </div>
</div>
    <!-- END VALIDATION STATES-->



@endsection