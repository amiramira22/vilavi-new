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
        </div>

        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-outline-primary m-btn m-btn--custom m-btn--icon m-btn--outline-2x m-btn--pill m-btn--air">
                        <span>
                            <i class="fas fa-cart-plus"></i>
                            <span>New User</span>
                        </span>
                    </a>
                </li>
                <li class="m-portlet__nav-item"></li>

            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <!--begin: Datatable -->
        <div class="table-responsive">
            <table class="table table-striped- table-bordered table-hover table-checkable"  id="user_table">
                <thead>
                    <tr>
                        <th class="text-center">photo</th>

                        <th class="text-center">Name</th>
                        <th class="text-center">Username</th>

                        <th class="text-center">Email</th>

                        <th class="text-center">Role</th>
                        <th class="text-center">Active</th>
                        <th class="text-center col-md-2">Actions</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                    <tr class="odd gradeX">
                        <?php
                        if (isset($user->photos))
                            $image = $user->photos;
                        else
                            $image = 'introuvable.png';
                        ?>

                        <td>
                            <img src="https://hcm.capesolution.tn/uploads/users/{{$image}}"  class="responsive-img left" height="50" width="50" alt="current" id="alert_<?php echo $user->id; ?>" onclick="show_picture(<?php echo $user->id; ?>, '<?php echo $image; ?>')">

                            <!--<img src="{{ asset('users/'.$image) }}"  class="responsive-img left" height="50" width="50" alt="current" id="alert_<?php echo $user->id; ?>" onclick="show_picture(<?php echo $user->id; ?>, '<?php echo $image; ?>')">-->
                        </td>


                        <td>{{ $user->name}}</td>
                        <td>{{ $user->username}}</td>
                        <td>{{ $user->email}}</td>

                        <td>{{ $user->access}}</td>
                        <td> 
                            @if($user->active==1)
                            <span class="m-badge  m-badge--info m-badge--wide">Enabled</span>'
                            @else 
                            <span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>
                            @endif  
                        </td>
                        <td class="text-center">


                            <a href="{{ route('admin.user.edit', $user->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>
                            </a>						
                            <a href="{{ route('admin.user.destroy', $user->id) }}"onclick="return confirm(\'Are you sure you want to delete this sale?\'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>
                            </a>

                            @if($user->active==1) 
                            <a href="{{ route('admin.user.disable',$user->id) }}"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                            @else
                            <a href="{{ route('admin.user.enable',$user->id) }}"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
                                <i class="fa fa-thumbs-up"></i>				
                            </a>
                            @endif


                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>




<script>
    var DatatablesBasicHeaders = {
        init: function () {
            $("#user_table").DataTable({
                responsive: !0,
                columnDefs: [{
                        targets: -1,
                        title: "Actions",
                        orderable: !1,

                    }]
            })
        }
    };
    $(document).ready(function () {
        DatatablesBasicHeaders.init()
    });


    function show_picture(id, image) {
        $("#alert_" + id).click(function (e) {
            swal({
                imageUrl: "http://localhost/bvm/public/users/" + image,
                imageAlt: "Custom image",
                animation: !1
            })
        })
    }

</script>


@endsection