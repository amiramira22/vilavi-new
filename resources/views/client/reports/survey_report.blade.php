@extends('layouts.client.template')
@section('title', '')

@section('content')

<script type="text/javascript">
    $(function () {
        $("#datepicker1").datepicker({

            dateFormat: 'dd/mm/yy',
            altField: '#datepicker1_alt',
            altFormat: 'yy-mm-dd'
        });

        $("#datepicker2").datepicker({

            dateFormat: 'dd/mm/yy',
            altField: '#datepicker2_alt',
            altFormat: 'yy-mm-dd'
        });
    });
</script>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light portlet-fit ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"  style="color:#337ab7 "></i>
                    <span class="caption-subjectbold uppercase bold"  style="color:#337ab7 ">Search</span>
                </div>
            </div>
            <div class="portlet-body form">


                {!! Form::open(['route' => ['client.report.survey'], 'method' => 'post', 'class' => 'form-horizontal']) !!}

                <div class="form-body">

                    <div class="form-group">
                        <label class="control-label col-md-2">Survey</label>
                        <div class="col-md-10">
                            {!! Form::select('survey_id',$surveys, null, ['class' => 'form-control']) !!}
                        </div>



                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Start Date <span class="required">
                                * </span>
                        </label>
                        <div class="col-md-3">
                            {!! Form::text(null, null, ['class' => 'form-control','id'=>'datepicker1', 'autocomplete'=>'off']) !!}
                            {!! Form::hidden('start_date', null, array('id' => 'datepicker1_alt')) !!}
                        </div>

                        <label class="control-label col-md-2">End Date <span class="required">
                                * </span>
                        </label>
                        <div class="col-md-3">
                            {!! Form::text(null, null, ['class' => 'form-control','id'=>'datepicker2', 'autocomplete'=>'off']) !!}
                            {!! Form::hidden('end_date', null, array('id' => 'datepicker2_alt')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">User </label>
                        <div class="col-md-3">
                            {!! Form::select('user_id',$users, null, ['class' => 'form-control']) !!}
                        </div>


                        <label class="control-label col-md-2">Export Excel</label>
                        <div class="col-md-3">
                            {!! Form::select('excel',array('0'=>'No', '1'=>'Yes'), null, ['class' => 'form-control']) !!}
                        </div>

                    </div>






                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            {!! Form::submit('Search', ['class' => 'btn btn-circle blue btn-outline']) !!}
                            <a class="btn btn-circle black btn-outline"  href="#">Reset </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>

    </div>
</div>	

@if (!empty($visits))
<div class="row">
    <div class="col-md-12">

        <table id="sales" class="table table-striped table-bordered">
            <thead>
                <tr> 
                    <th>Chef Zone</th>
                    <th>Code Client</th>
                    <th>Gouvernorat</th>
                    <th>Delegation</th>
                    <th>Localite</th>
                    <th>Date</th>
                    @foreach($questions as $question)

                    <th>{{ $question->question}}</th>
                    @endforeach

                </tr>
            </thead>
            <tbody>




                @foreach($visits as $visit)
                <tr class="odd gradeX">

                    <td>{{ $visit['chef_zone']}}</td>
                    <td>{{ $visit['code_client']}}</td>
                    <td>{{ $visit['gouvernorat']}}</td>
                    <td>{{ $visit['delegation']}}</td>
                    <td>{{ $visit['localite']}}</td>
                    <td>{{ $visit['date']}}</td>
                    @foreach($questions as $question)
                    <td>
                        @if(isset($visit['answers'][$question->id])) 
                        {{ $visit['answers'][$question->id]}}
                         @else
                         -
                         @endif 
                    </td>
                    @endforeach
                </tr>
                @endforeach
                </tr>
            </tbody>
        </table>

    </div>
</div>
@endif

@endsection