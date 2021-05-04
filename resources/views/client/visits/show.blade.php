@extends('layouts.client.template')
@section('content')


<div class="portlet light portlet-fit ">

    <div class="portlet-title">

        <div class="caption">
            <i class="fa fa-shopping-cart"  style="color:#0057A4 "></i>
            <span class="caption-subject bold uppercase"  style="color:#0057A4 ">{{$title}} - {{$visit->survey->title}} - {{reverse_format($visit->date)}} </span>
        </div>
    </div>


    <div class="portlet-body form">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" >
                        <caption><h3>{{$visit->user->name}} - {{$visit->description}} - {{reverse_format($visit->date)}}</h3></caption>
                        @foreach ($answers as $answer)
                        @php
                        $options=json_decode($answer->question->options);
                        @endphp
                        <tr>
                            <th>{{$answer->question->order}} - {{$answer->question->question}}</th>
                            <td>
                                @if($answer->question->type=='Text') 
                                {{$answer->text_value}}
                                @elseif($answer->question->type=='Single')
                                {{$options[$answer->radio_value]}}
                                @else
                                   @php
                                    $check_answers=json_decode($answer->checkbox_value);
                                   @endphp
                                   @foreach ($check_answers as $check_answer)
                                   - {{$options[$check_answer]}} <br>
                                   @endforeach
                                
                                @endif 
                            </td>
                        </tr>

                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection