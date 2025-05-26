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

                                        <form class="form" action="{{route('admin.updatePassword')}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('post')
                                            
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="first-name-column">Old Password</label>
                                                        <div class="form-label-group">
                                                            <input type="password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Password" name="old_password" value="" autocomplete="off" required>
                                                            @error('old_password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                    
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                                <div class="row">
                                                    
                                                    <div class="col-12">
                                                        <label for="first-name-column">New Password</label>
                                                        <div class="form-label-group">
                                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="New Password" name="password" value="" autocomplete="off" required>

                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                           
                                                        </div>
                                                    </div>
                                                   
                                                 
                                                </div>

                                                <div class="row">
                                                    
                                                    <div class="col-12">
                                                        <label for="first-name-column">Confirm Password</label>
                                                        <div class="form-label-group">
                                                            <input type="password" id="Confirm Password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" name="password_confirmation" value="" autocomplete="off" required>
                                                            @error('password_confirmation')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Update
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
    </script>
@endsection
