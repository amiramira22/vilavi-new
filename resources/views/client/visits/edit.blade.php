@extends('layouts.client.template')
@section('content')

<div class="container"> 
          <a class="btn btn-circle blue btn-outline btn-block" href="{{ route('client.visit.updateClient',$visit->id) }}"><i class="fa fa-check-square-o"></i>	Save & Finish</a>
</div>
<br/>
<div class="portlet light portlet-fit ">

    <div class="portlet-title">

        <div class="caption">
            <i class="fa fa-shopping-cart"  style="color:#0057A4 "></i>
            <span class="caption-subject bold uppercase"  style="color:#0057A4 ">{{$title}} - {{$visit->survey->title}} - {{reverse_format($visit->date)}} </span>
        </div>
    </div>

    <style>
        .form-horizontal .control-label{
            text-align: left
        }

        input[type=checkbox], input[type=radio]{
            -ms-transform: scale(2); /* IE */
            -moz-transform: scale(2); /* FF */
            -webkit-transform: scale(2); /* Safari and Chrome */
            -o-transform: scale(2); /* Opera */
            padding: 10px;
        }

    </style>

    <div class="portlet-body form">


        <div class="form-body">
            {!! Form::open(['url' => NULL, 'method' => 'get', 'class' => 'form-horizontal form-bordered']) !!}	
			
			@if (($visit->survey->display_client) == 1)
            <div class="form-group" >
                <label class="control-label col-md-3">Gouvernorat <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!!  Form::select('gouv_name',$gouvernorats,NULL, ['class' => 'form-control', 'id' => 'gouv_name']) !!}
                </div>
            </div>

            <div class="form-group" >
                <label class="control-label col-md-3">Delegation <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!!  Form::select('deleg_name',array(),NULL, ['class' => 'form-control', 'id' => 'deleg_name']) !!}
                </div>
            </div>
            
             <div class="form-group">
                <label class="control-label col-md-3">Localite <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!!  Form::select('localite_name',array(),NULL, ['class' => 'form-control', 'id' => 'localite_name']) !!}
                </div>
            </div>
            <div class="form-group" id="content_client">
                <label class="control-label col-md-3">Client <span class="required">
                        * </span>
                </label>
                <div class="col-md-6">
                    {!!  Form::select('client_id',$clients,$visit->client_id, ['class' => 'form-control',
                    'onchange' => 'update_visit()', 'id' => 'client_id']) !!}
                </div>
            </div>

			 
			@endif 
			
            @foreach ($answers as $answer)

            <div class="form-group" id="content{{$answer->id}}">
                <label class="control-label col-md-6" ><b>{{$answer->question->order}}</b> - {{$answer->question->question}} </label>
                <div class="col-md-6">
                    @php
                    $options=json_decode($answer->question->options);
                    @endphp

                    @if($answer->question->type=='Text')

                    {!! Form::text('answer_text', $answer->text_value, ['class' => 'form-control',
                    'onchange' => 'update_text(' . $answer->id . ')', 'id'=>'answer'.$answer->id]) !!}

                    @elseif($answer->question->type=='Single')


                    @foreach($options as $key=>$value)
                    <div class="control-label " >
                        <label>
                            {{ Form::radio('answer'.$answer->id,$key, $key==$answer->radio_value, array('id'=>'answer'.$answer->id,
                    'class' => 'form-control1','onchange' => 'update_radio( ' . $answer->id .','.$key.')')) }} {{$value}} <br>
                        </label>
                    </div>

                    @endforeach

                    @else

                    @foreach($options as $key=>$value)
                    <div class="checkbox control-label " style="margin-left: 20px;" >
                        <label>
                            {!! Form::checkbox('answer'.$answer->id, $key, in_array($key,json_decode($answer->checkbox_value)), 
                            ['class' => 'form-control1',
                            'onchange' => 'update_checkbox( ' . $answer->id .')', 'id'=>'answer'.$answer->id]) !!} {{$value}} <br>
                        </label>
                    </div>

                    @endforeach

                    @endif 

                </div>
            </div>
            @endforeach

            {!! Form::close() !!}
        </div>




    </div>
</div>


<script>
    function update_checkbox(id) {
        var result = [];
        answer_values = document.getElementsByName("answer" + id);
        for (e = 0; e < answer_values.length; e++)
        {
            if (answer_values[e].checked == true)
            {
                result.push(answer_values[e].value);
                //addon += parseInt(av[e].value, 10);

            }
        }

        jQuery.ajax({
            type: "POST",
            "url": "<?= route('client.visit.updateAnswer') ?>",

            "data": {"_token": "<?= csrf_token() ?>",
                "answer_id": id,
                "checkbox_value": JSON.stringify(result),
                "type": "Checkbox"

            },
            cache: false,
            success: function (data) {

                document.getElementById('content' + id).style.backgroundColor = "#b2ffb2";
            },
            error: function (data) {
                document.getElementById('content' + id).style.backgroundColor = "#ffb2b2";
            }
        }
        );

    }

    function update_radio(id, key) {


        jQuery.ajax({
            type: "POST",
            "url": "<?= route('client.visit.updateAnswer') ?>",

            "data": {"_token": "<?= csrf_token() ?>",
                "answer_id": id,
                "radio_value": key,
                "type": "Radio"

            },
            cache: false,
            success: function (data) {

                document.getElementById('content' + id).style.backgroundColor = "#b2ffb2";
            },
            error: function (data) {
                document.getElementById('content' + id).style.backgroundColor = "#ffb2b2";
            }
        }
        );

    }

    function update_text(id) {

        text = document.getElementById('answer' + id).value;
        jQuery.ajax({
            type: "POST",
            "url": "<?= route('client.visit.updateAnswer') ?>",

            "data": {"_token": "<?= csrf_token() ?>",
                "answer_id": id,
                "text_value": text,
                "type": "Text"

            },
            cache: false,
            success: function (data) {

                document.getElementById('content' + id).style.backgroundColor = "#b2ffb2";
            },
            error: function (data) {
                document.getElementById('content' + id).style.backgroundColor = "#ffb2b2";
            }
        }
        );

    }

    function update_visit() {

        client_id = document.getElementById('client_id').value;
        jQuery.ajax({
            type: "POST",
            "url": "<?= route('client.visit.updateVisit') ?>",

            "data": {"_token": "<?= csrf_token() ?>",
                "visit_id": "{{$visit->id}}",
                "client_id": client_id

            },
            cache: false,
            success: function (data) {

                document.getElementById('content_client').style.backgroundColor = "#b2ffb2";
            },
            error: function (data) {
                document.getElementById('content_client').style.backgroundColor = "#ffb2b2";
            }
        }
        );

    }




</script>


<script type="text/javascript">


    $(document).ready(function () {

        $('#deleg_name').on('change', function () {
            var deleg_name = $(this).val();

            if (deleg_name) {
                $.ajax({
                    url: '{{ route("client.visit.getLocalites") }}',
                    data: {
                        "_token": "<?= csrf_token() ?>",
                        'deleg_name': deleg_name,
                    },
                    type: "POST",
                    dataType: "json",

                    success: function (data) {
                        console.log(data);

                        $('#localite_name').empty();
                        $.each(data, function (key, value) {

                            $('#localite_name').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },

                });
            
             $.ajax({
                    url: '{{ route("client.visit.getClients") }}',
                    data: {
                        "_token": "<?= csrf_token() ?>",
                        'gouv_name': "-1",
                        'deleg_name': deleg_name,
                        'localite_name': "-1",
                    },
                    type: "POST",
                    dataType: "json",

                    success: function (data) {
                        console.log(data);

                        $('#client_id').empty();
                        $.each(data, function (key, value) {

                            $('#client_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },

                });
            } else {
                $('#localite_name').empty();
            }

        });
    });
</script>


<script type="text/javascript">


    $(document).ready(function () {

        $('#localite_name').on('change', function () {
            var localite_name = $(this).val();

            if (localite_name) {
                $.ajax({
                    url: '{{ route("client.visit.getClients") }}',
                    data: {
                        "_token": "<?= csrf_token() ?>",
                        'gouv_name': "-1",
                        'deleg_name': "-1",
                        'localite_name': localite_name,
                    },
                    type: "POST",
                    dataType: "json",

                    success: function (data) {
                        console.log(data);

                        $('#client_id').empty();
                        $.each(data, function (key, value) {

                            $('#client_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },

                });
            } else {
                $('#client_id').empty();
            }

        });
    });
</script>


<script type="text/javascript">


    $(document).ready(function () {

        $('#gouv_name').on('change', function () {
            var gouv_name = $(this).val();

            if (gouv_name) {
                $.ajax({
                    url: '{{ route("client.visit.getDelegations") }}',
                    data: {
                        "_token": "<?= csrf_token() ?>",
                        'gouv_name': gouv_name,
                    },
                    type: "POST",
                    dataType: "json",

                    success: function (data) {
                        console.log(data);

                        $('#deleg_name').empty();
                        $.each(data, function (key, value) {

                            $('#deleg_name').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },

                });
            
             $.ajax({
                    url: '{{ route("user.visit.getClients") }}',
                    data: {
                        "_token": "<?= csrf_token() ?>",
                        'gouv_name': gouv_name,
                        'deleg_name': "-1",
                        'localite_name': "-1"
                    },
                    type: "POST",
                    dataType: "json",

                    success: function (data) {
                        console.log(data);
                    

                        $('#client_id').empty();
                        $.each(data, function (key, value) {

                            $('#client_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },

                });
            } else {
                $('#deleg_name').empty();
            }

        });
    });
</script>

@endsection