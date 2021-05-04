@extends('layouts.admin.template')

@section('content')

<script src="{{ asset('assets/demo/default/custom/header/actions.js') }}"></script>
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-chat-1 m--font-danger"></i> 
                </span>
                <h3 class="m-portlet__head-text m--font-danger">
                    List Of Messages
                </h3>
            </div>			
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="#" class="btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-primary" data-toggle="modal" data-target="#m_modal_4">
                        New Message
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-section">
            <div class="m-section__content">
                <div class="table-responsive">
                    <table class="table table-striped m-table">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>To</th>
                                <th>Date</th>
                                <th>Viewed</th>
                                <th colspan="">Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $msg)
                            <?php //print_r($msg) ?>
                            <tr>
                                <td> {{App\Entities\User::find($msg->sender_id)->name}}</td>
                                <td> {{App\Entities\User::find($msg->receiver_id)->name}}</td>

                                <td>
                                    {{reverse_format($msg->created_date)}}
                                    <?php echo '<br>'; ?>
                                    {{$msg->created_time}}
                                </td>
                                <td>
                                    @if($msg->viewed == 1)
                                    <i class="fa fa-check m--font-primary"></i>
                                    @elseif($msg->viewed == 0)
                                    <i class="fa fa-times m--font-danger"></i>
                                    @endif
                                </td>
                                <td colspan="">
                                    {{$msg->message}}
                                </td>
                                <td>
                                    <a href="{{ route('admin.user.delete_message', $msg->id) }}"onclick="return confirm(\'Are you sure you want to delete this sale?\'" class="btn m-btn--pill    btn-outline-danger btn-sm" title="Delete">	
                                        <i class="fas fa-trash"></i>
                                    </a>
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



<!--begin::Modal-->
<div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header ">

                <h5 class="modal-title  m--font-danger" id="exampleModalLabel">    
                    <i class="fa fa-plus m--font-danger"></i>
                    <span style="padding-left:10px;"></span>

                    New message  
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {!! Form::open(['url' => 'admin/user/postMessage', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off' ]) !!}
                <div class="m-portlet__body">
                    <div class="form-group">
                        <label class="col-md-2">To</label>
                        <div class="col-md-8">
                            {!! Form::select('fo_ids[]', $fos ,null,['class' => 'form-control ','data-actions-box'=>'true','id'=>'m_select_channel','multiple','required' => 'required']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Content</label>
                        <div class="col-md-12">
                            <!--<div class="summernote">-->
                            {!! Form::textarea('message',null,['class' => 'form-control summernote','required' => 'required']) !!}
                            <!--</div>-->
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">

                <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-danger">Send</button>
                <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary">Cancel</button>

            </div>
        </div>
        </form>
    </div>
</div>

<!--end::Modal-->

@endsection
