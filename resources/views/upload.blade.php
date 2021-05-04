@extends('layouts.admin.template')

@section('content')

<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-chat-1 m--font-danger"></i> 
                </span>
                <h3 class="m-portlet__head-text m--font-danger">
                    List Of ANDROID APP
                </h3>
            </div>			
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="#" class="btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-primary" data-toggle="modal" data-target="#m_modal_4">
                        New ANDROID APP
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
                                <th>Name</th>
                                <th>Version</th>
                                <th>active</th>
                                <!--<th>date</th>-->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($files)
                            @foreach($files as $file)
                            <tr>
                                <td> {{$file->name}}</td>
                                <td> {{$file->version}}</td>
                                <!--<td> {{$file->version}}</td>-->

                                <td>
                                    @if($file->active == 1)
                                    <i class="fa fa-check m--font-primary"></i>
                                    @elseif($file->active == 0)
                                    <i class="fa fa-times m--font-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.upload.deleteFile', $file->id) }}"onclick="return confirm(\'Are you sure you want to delete this sale?\'" class="btn m-btn--pill    btn-outline-danger btn-sm" title="Delete">	
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="{{ asset('apk/'.$file->file) }}" class="btn m-btn m-btn--pill m-btn--gradient-from-metal m-btn--gradient-to-accent btn-sm"  download><i class="fa fa-download"></i> Download</a>

                                </td>
                            </tr>
                            @endforeach
                            @endif
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
                    New ANDROID APP  
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => 'admin/upload/postFile', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right','autocomplete'=>'off',  'enctype' => 'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-xl-8 offset-xl-2">
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-xl-2 col-lg-2 col-form-label"> Name </label>
                                <div class="col-xl-9 col-lg-9">
                                    <input class="form-control m-input" placeholder="Name" name="name" type="text" required>

                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-2 col-lg-2 col-form-label"> Version </label>
                                <div class="col-xl-9 col-lg-9">
                                    <input class="form-control m-input" placeholder="Version" name="version" type="text" required>

                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-xl-2 col-lg-2 col-form-label" for="exampleInputEmail1">File </label>
                                <div class="col-xl-9 col-lg-9 custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-danger">Submit</button>
                <button type="reset" class="btn m-btn--pill m-btn--air btn-outline-primary">Cancel</button>
            </div>
            </form>
        </div>

    </div>
</div>
<!--end::Modal-->
@endsection
