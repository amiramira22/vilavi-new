@extends('layouts.admin.template')


@section('content')


    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!--@if(request()->session()->has('message'))
        <p class="alert {{ request()->session()->get('alert-class', 'alert-info') }}">{{ request()->session()->get('message') }}</p>
@endif-->

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">

                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-list-3 m--font-danger"></i>
                </span>
                        <h3 class="m-portlet__head-text m--font-danger">
                            @if(isset($subTitle)) {{ $subTitle }}  @endif
                        </h3>
                    </div>

                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">

                            </li>
                            <li class="m-portlet__nav-item"></li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin: Datatable -->
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="model_tab">
                        <thead>
                        <tr>
                            <th>@lang('project.BRAND')</th>
                            <th>@lang('project.PRODUCT')</th>
                            @if ($visit->monthly_visit == 0)
                                <th colspan="3">@lang('project.AVAILIBILTY') </th>
                            @elseif ($visit->monthly_visit != 0)
                                <th>@lang('project.SHELF_SHARE')</th>
                                <th> @lang('project.PRIX') </th>
                                <th> @lang('project.PROMOTION') </th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>

                        @foreach ($models as $model)
                            <tr>

                                <td>{{ $model->brand_name}}</td>
                                <td>{{ $model->product_name}}</td>
                                @if ($visit->monthly_visit == 0)
                                    <td id="<?php echo $model->id . 'av'; ?>" style="background-color: #ffffff">
                                        <input type="radio"
                                               name="av{{ $model->id}}"
                                               value="1" {{ $model->av == '1' ? 'checked' : '' }}
                                               class="radioBtnClass"
                                               onclick="saveAv({{ $model->id}}, 1, 'av')">
                                        <font color="blue"><b>AV </b></font>
                                    </td>

                                    <td id="<?php echo $model->id . 'oos'; ?>" style="background-color: #ffffff">
                                        <input type="radio" name="av{{ $model->id}}" value="0"
                                               {{ $model->av == '0' ? 'checked' : '' }} class="radioBtnClass"
                                               onclick="saveAv({{ $model->id}}, 0, 'av')">
                                        <font color="blue"><b>OOS </b></font>
                                    </td>

                                    <td id="<?php echo $model->id . 'ha'; ?>" style="background-color: #ffffff">
                                        <input type="radio" name="av{{ $model->id}}" value="2"
                                               {{ $model->av == '2' ? 'checked' : '' }} class="radioBtnClass"
                                               onclick="saveAv({{ $model->id}}, 2, 'av')">
                                        <font color="blue"><b>HA </b></font>
                                    </td>


                                @elseif ($visit->monthly_visit != 0)
                                    <td id="">
                                        <input id="{{$model->id}}shelf" type="text" name="" value="{{$model->shelf}}"
                                               class="form-control m-input"
                                               onchange="saveAv({{ $model->id}}, this.value, 'shelf')">
                                    </td>

                                    <td id="">
                                        <input id="{{$model->id}}price" type="text" name="" value="{{$model->price}}"
                                               class="form-control m-input"
                                               onchange="saveAv({{ $model->id}}, this.value, 'price')">
                                    </td>
                                    <td id="">
                                        <input id="{{$model->id}}promo_price" type="text" name=""
                                               value="{{$model->promo_price}}" class="form-control m-input"
                                               onchange="saveAv({{ $model->id}}, this.value, 'promo_price')">
                                    </td>
                                @endif

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <script>

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            function saveAv(model_id, data, type) {
                $.ajax({

                    url: '<?= route('visit.postDataModel') ?>',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, model_id: model_id, visit_id:{{$visit_id}}, data: data, type: type},
                    dataType: 'JSON',
                    success: function (data) {
                        console.log('avail  ' + data.type);
                        console.log('data  ' + data.data);
                        console.log('visit_id  ' + data.visit_id);
                        console.log('model_id  ' + data.model_id);
                        document.getElementById(model_id + type).style.backgroundColor = "#b2ffb2";
                       },
                    error: function (data) {
                        document.getElementById(model_id + type).style.backgroundColor = "#f97777";
                        //document.getElementById(model_id + type).style.backgroundColor = "#b2ffb2";
                    },
                });
            }

        </script>

@endsection