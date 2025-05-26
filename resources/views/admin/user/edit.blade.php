@extends('admin.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <x-admin-breadcrumb :title="$titles['title']"></x-admin-breadcrumb>
            </div>
            <div class="content-body">

                <!-- Editing Form -->
                <section id="multiple-column-form" class="bootstrap-select">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        <x-admin-error-list-show></x-admin-error-list-show>

                                        <form class="form" action="{{route('admin.updateUser', $user->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('post')
                                            <input type="hidden" name="user_id" value="{{$user->id}}">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">First Name</label>
                                                        <div class="form-label-group">
                                                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="First Name" name="first_name" value="{{$user->first_name}}" autocomplete="off">
                                                            @error('first_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Last Name</label>
                                                        <div class="form-label-group">
                                                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Last Name" name="last_name" value="{{$user->last_name}}" autocomplete="off">
                                                            @error('last_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Email</label>
                                                        <div class="form-label-group">
                                                            <input type="email" id="name" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{$user->email}}" autocomplete="off">
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12"><label for="first-name-column">Role</label>
                                                        <div class="form-label-group">
                                                            <select name="role_id" class="form-control @error('role_id') is-invalid @enderror"">
                                                                @foreach($roles as $role)
                                                                    <option
                                                                        value="{{$role->id}}" {{$user->roles->contains($role->id) ? 'selected' : ''}}>{{$role->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('role_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                 
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Mobile</label>
                                                        <div class="form-label-group">
                                                            <input type="text" id="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" name="mobile" value="{{$user->mobile}}" autocomplete="off">
                                                            @error('mobile')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                           
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Profile Pic</label>
                                                        <div class="form-label-group">
                                                            <input type="file" id="mobile" class="form-control " placeholder="Profile Pic" name="profile_pic"  autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                            

                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Save
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Editing Form Ends -->
            </div>
        </div>
    </div>

@endsection


@section('extrascript')
    <script>
        $('.zero-configuration').DataTable(
            {
                "displayLength": 50,
            }
        );

        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif

        // Functionality section

        $('.deleteBtn').on("click", function () {
            let id = $(this).data('id');
            let url = '{{ route("role.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        });
    </script>
@endsection
