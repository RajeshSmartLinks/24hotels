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

                <!-- Adding Form -->
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
                                        {{-- <x-admin-error-list-show></x-admin-error-list-show> --}}
                                        @can('operator-add')
                                        <form class="form" action="{{route('operator.store')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">First Name</label>
                                                        <div class="form-label-group">
                                                            <input type="text" id="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" name="first_name" value="{{old('first_name')}}" autocomplete="off">
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
                                                            <input type="text" id="name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name" name="last_name" value="{{old('last_name')}}" autocomplete="off">
                                                            @error('last_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                   
                                                </div>

                                                <div class="row">
                                                    {{-- <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" name="mobile" value="{{old('mobile')}}" autocomplete="off">
                                                            @error('mobile')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <label for="first-name-column">Mobile</label>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Email</label>
                                                        <div class="form-label-group">
                                                            <input type="email" id="name" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{old('email')}}" autocomplete="off">
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                           
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Role</label>
                                                        <div class="form-label-group">
                                                            <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                                                @foreach($roles as $role)
                                                                    <option
                                                                        value="{{$role->id}}">{{$role->name}}</option>
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
                                                        <label for="first-name-column">Password</label>
                                                        <div class="form-label-group">
                                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" value="" autocomplete="off">
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Confirm Password</label>
                                                        <div class="form-label-group">
                                                            <input type="password" id="Confirm Password" class="form-control" placeholder="Confirm Password" name="password_confirmation" value="" autocomplete="off">
                                                            
                                                            
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
                                        @endcan

                                        <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Adding Form Ends -->

                <!-- List Datatable Starts -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['listTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Sr no</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                   
                                                    <th>Role</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($operators) > 0)
                                                    @foreach($operators as $operator)
                                                        <tr>
                                                            <td>{{$loop->iteration }}</td>
                                                            <td>{{$operator->first_name ." ".$operator->last_name}}</td>
                                                            <td>{{$operator->email}}</td>
                                                            <td>
                                                                @foreach($operator->roles as $role)
                                                                    {{$role->name}}
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @can('operator-edit')
                                                                <a href="{{ route('operator.edit', $operator->id) }}"><i
                                                                        class="feather icon-edit"></i> Edit</a> |
                                                                @endcan
                                                                @can('operator-delete')        
                                                                <a href="javascript:" class="text-danger deleteBtn"
                                                                   data-id="{{$operator->id}}"
                                                                   data-toggle="modal"
                                                                   data-target="#deleteModal" id="deleteBtn"><i
                                                                        class="feather icon-trash"></i> Delete</a>
                                                                @endcan        
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="4">No Record(s)</td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- List Datatable Ends -->
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
            let url = '{{ route("operator.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        });
    </script>
@endsection
