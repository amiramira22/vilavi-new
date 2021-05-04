
@extends('layouts.admin.template')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<script>
$(function () {
    $('.datepicker').datepicker({

        dateFormat: 'dd mm yyyy',
        multidate: true,
        daysOfWeekDisabled: [0],
        clearBtn: true,
        todayHighlight: true,
        daysOfWeekHighlighted: [1, 2, 3, 4, 5, 6],
        autoclose: false,
        altField: '#datepicker_alt',
        altFormat: 'yy-mm-dd'

    });

    $('.datepicker').on('changeDate', function (evt) {
        console.log(evt.date);
    });

    $('.btn').on('click', function () {
        var the_date = $('.datepicker:first').datepicker('getDates');
        console.log(the_date);
    });
});
</script>

<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-add-circular-button m--font-danger"></i>
                </span>
                <h3 class="m-portlet__head-text m--font-danger" style="">
                      @lang('project.ADD')
                </h3>
            </div>
        </div>
    </div>


    {!! Form::open(['url' => 'admin/fo_report/save_fo_information', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">

            <!-- *****************************CONTROL VISIT *************************************************************** -->
            <div class="col-lg-1"></div>

            <div class="col-lg-3">

                <div class="datepicker control-label" data-date-format="yyyy-mm-dd" id="datepicker">
                    <input type="hidden" name="date" id="datepicker_alt" required/>	
                </div>
            </div>

            <div class="col-lg-6">

                {!! Form::select('fo_id', $fos , $fo_id ,['class' => 'form-control','id'=>'']) !!}
                <br>
                <!--    <option value="" disabled selected>Select your option</option>-->
                <select name="type" class="form-control" required>
                    <option value="" disabled selected>select item type</option>
                    <option value="Holiday">Holiday</option>
                    <option value="Routing">Routing</option>
                    <option value="Authorization">Authorization</option>
                </select>
                <br>                               
                {!! Form::textarea('note', null, ['rows' => 4, 'cols' => 50, 'class' => 'form-control']) !!}
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div> <!-- end form-body -->


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

<script>
    $(document).ready(function () {
        $('#specific_fo').each(function () {
            $(this).children('option:first').attr("disabled", "disabled selected");
        });
    });
</script>


@endsection