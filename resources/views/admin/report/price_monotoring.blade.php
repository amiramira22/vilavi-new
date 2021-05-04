@extends('layouts.admin.template')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
    $(function () {
        $("#datepicker1").datepicker({
            changeMonth: true,
            changeYear: true,

            dateFormat: 'MM yy',
            altField: '#datepicker1_alt',
            altFormat: 'yy-mm-dd',
            onClose: function (dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            },

        });
    });
</script>
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
    {!! Form::open(['url' => 'admin/report/price_monotoring', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}

    <style>
        .m-form .m-form__actions {
            padding: 15px;
        }
        .m-form .m-form__group {
            margin-bottom: 10px;
            padding-top: 30px;
            padding-bottom: 30px;

        }

    </style>
    <div class="form-group m-form__group row">


        <label class="col-md-1 col-form-label">  @lang('project.MONTH')</label>
        <div class="col-md-3">
            {!! Form::text('start_date', format_qmw_date('month', $start_date), ['class' => 'form-control m-input', 'placeholder' => 'Month','id'=>'datepicker1','required'=>'required']) !!}
            {!! Form::hidden('start_date_m', $start_date, ['class' => 'form-control m-input', 'placeholder' => 'Start Date','id'=>'datepicker1_alt','required'=>'required']) !!}

        </div>

        <label class="col-md-1 col-form-label">  @lang('project.CATEGORIE')</label>
        <div class="col-md-3">
            {!! Form::select('category_id', $categories , $category_id ,['class' => 'form-control m-select2','id'=>'m_select_category']) !!}

        </div>

        <label class="col-md-1 col-form-label">@lang('project.CHANNEL')</label>
        <div class="col-md-3">
            {!! Form::select('channel_id', $channels , $channel_id ,['class' => 'form-control m-select2','id'=>'m_select_channel']) !!}

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
<style>
    .m--font-danger{
        color: #2c3d96 !important;
    }
    .m-demo .m-demo__preview {
        background: white;
        border: 4px solid #ffffff;
        padding: 30px;
    }
</style>
<?php
if ($start_date && $clusters && !empty($clusters->toArray())) {

    foreach ($clusters as $cluster) {

        if ($cluster->id != -1) {
            $cluster_id = $cluster->id;
            $cluster_name = $cluster->name;
            ?> 
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m-portlet__head-text m--font-danger">
                                <?php echo $cluster_name; ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin::Section-->
                    <div class="m-section">
                        <div class="m-section__content" id="content_cluster<?php echo $cluster_id; ?>">  </div>

                        <script type="text/javascript">

                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $('#content_cluster<?php echo $cluster_id; ?>').html('<div class="col-md-12" align="center"><img width="120px" src="<?php echo asset('img/Loader.gif'); ?>" class="img-responsive img-center" /></div>');
                            jQuery.ajax({
                                type: 'post',
                                url: '<?= route('admin.report.load_price_monotoring_per_cluster') ?>',
                                data: {_token: CSRF_TOKEN,
                                    start_date: "<?php echo $start_date; ?>",
                                    cluster_id: "<?php echo $cluster_id; ?>",
                                    channel_id: "<?php echo $channel_id; ?>",
                                    category_id: "<?php echo $category_id; ?>"
                                },

                                success: function (data) {
                                    $('#content_cluster<?php echo $cluster_id; ?>').html(data);
                                }
                            });
                        </script>


                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>
<script>
    var Select2 = {
        init: function () {
            $("#m_select_category,#m_select_channel").select2({
            });
        }
    };
    jQuery(document).ready(function () {
        Select2.init();
    });
</script>



@endsection