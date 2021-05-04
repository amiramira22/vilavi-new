@extends('layouts.client.template')


@section('content')





<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-red"></i>
            <span class="caption-subject font-red bold uppercase">{{$subTitle}}</span>
        </div>
        
        
    </div>
    <div class="portlet-body form">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" >
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> User </th>
                                <th>Gouvernorat</th>
                                <th>Delegation</th>
                                <th>Localite</th>
                                <th> Code client </th>
                                <th> Date </th>                                
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visits as $visit)
                            <tr class="odd gradeX">
                                <td>{{ $visit->id}}</td>
                                <td>{{ $visit->user->name}}</td>
                                <td>
                                   @if(isset($visit->client->gouvernorat)) 
                                    {{ $visit->client->gouvernorat }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($visit->client->delegation))
                                    {{ $visit->client->delegation }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($visit->client->localite))    
                                        {{ $visit->client->localite }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($visit->client->code_client))
                                    {{ $visit->client->code_client }}
                                    @endif
                                </td>                                
                                <td>
                                  
                                    {{ reverse_format($visit->date)}}
                                    
                                </td>
                               
                                <td>                               
                                    <a class="btn btn-circle blue btn-outline" href="{{ route('client.visit.edit', $visit->id) }}"> <i class="fa fa-pencil"></i> </a>	
                              
                                    <a class="btn btn-circle blue btn-outline" href="{{ route('client.visit.show',$visit->id) }}"><i class="fa fa-eye"></i>	</a>
                                 <!--    {!! Form::open(array(
                                'method' => 'DELETE',
                                'route' => ['admin.visit.destroy', $visit->id],
                                'onsubmit' => "return confirm('Are you sure you want to delete?')",
                                'style'=>"display: inline",
                                ))!!}

                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-circle red btn-outline'] )  }}

                                {!! Form::close() !!} -->
                                </td>                            
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 ">

        <center> {!! $links !!} </center> 
    </div>
</div>


  <script type="text/javascript">
        function areyousure()
        {
            return confirm('Are you sure you want to delete this user?');
        }
  </script>

@endsection