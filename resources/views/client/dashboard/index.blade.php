@extends('layouts.client.template')
@section('title', 'Dashboard & Statistics' )

@section('content')
<div class="row">
     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-blue-sharp">
                        <span data-counter="counterup" data-value="{{$totalDailyVisits}}">{{$totalDailyVisits}}</span>
                        <small class="font-blue-sharp">Visits</small>
                    </h3>
                    <small>Total Daily Visits</small>
                </div>
                <div class="icon">
                    <i class="icon-basket"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width:100%;" class="progress-bar progress-bar-success blue-sharp">
                        <span class="sr-only"></span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title">  </div>
                    <div class="status-number"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-red-haze">
                        <span data-counter="counterup" data-value="{{$totalVisits}}">{{$totalVisits}}</span>
                        <small class="font-red-haze">Visits</small>
                    </h3>
                    <small>Total Visits</small>
                </div>
                <div class="icon">
                    <i class="icon-like"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: 100%;" class="progress-bar progress-bar-success red-haze">
                        <span class="sr-only"></span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title">  </div>
                    <div class="status-number">  </div>
                </div>
            </div>
        </div>
    </div>
   
</div>

@endsection