@extends('layouts.admin.template')
@section('content')
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
        <div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="800" data-mobile-height="800" style="height: 500px; ">
            <?php
            echo $maps['js'];
            echo $maps['html'];
            ?>
        </div>
    </div>
</div>

@endsection