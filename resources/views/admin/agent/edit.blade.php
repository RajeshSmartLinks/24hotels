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

                <!-- invoice functionality start -->
                <section class="invoice-print mb-1">
                    <div class="row">
                        <fieldset class="col-12 col-md-5 mb-1 mb-md-0">&nbsp;</fieldset>
                        <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
                            @can('agent-view')
                            <a href="{{route('agents.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-list"></i>&nbsp;Go to List</a>
                            </a>
                            @endcan
                        </div>
                    </div>
                </section>

                <!-- Adding Form -->
                <section id="multiple-column-form" class="input-validation">
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


                                        <form class="form-horizontal" action="{{route('agents.update', $editagent->id)}}" method="post"
                                              enctype="multipart/form-data" >
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first_name">First Name</label>
                                                            <input type="text" id="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" name="first_name" value="{{old('first_name', $editagent->first_name)}}" autocomplete="off" required>
                                                            @error('first_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror 
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name</label>
                                                            <input type="text" id="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name" name="last_name"  value="{{old('last_name', $editagent->last_name)}}" autocomplete="off"required>
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
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            
                                                            <input type="email"   class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{old('email', $editagent->email)}}" required>
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                       
                                                            <div class="form-group">
                                                                <label for="mobile">Mobile</label>
                                                    
                                                                <input type="number"   class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" name="mobile"  value="{{old('mobile', $editagent->mobile)}}" required>
                                                                @error('mobile')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                       
                                                    </div>
                                                </div>
                                             


                                                <div class="row">
                                                    <div class= "col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="valid_from">Status</label>
                                                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="basicSelect" required>
                                                                <option value="">--select status --</option>
                                                                <option value="Active" {{(old('status', $editagent->status) == "Active")?"selected":""}}>Active</option>
                                                                <option value="InActive" {{(old('status', $editagent->status) == "InActive")?"selected":""}}>InActive</option>
                                                            </select>
                                                            @error('status')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class= "col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="valid_from">Agency</label>
                                                            <select name="agency_id" class="form-control @error('agency_id') is-invalid @enderror" id="basicSelect" disabled>
                                                                <option value="">--select agency_id --</option>
                                                                @foreach($agencies as $agency)
                                                                    <option value="{{$agency->id}}" @if (old('agency_id' , $editagent->agency_id) == $agency->id) {{ 'selected' }} @endif>{{$agency->name}}</option>
                                                                @endforeach
                                                               
                                                            </select>
                                                            @error('agency_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>&nbsp;</div>
                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Save
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
                <section id="multiple-column-form" class="input-validation">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitleTwo']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        {{-- <x-admin-error-list-show></x-admin-error-list-show> --}}


                                        <form class="form-horizontal" action="{{route('updateAgentPassword' , $editagent->id)}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            @method('POST')
                                            <div class="form-body">
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
                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Save
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
                {{-- @can('agent-add-credit')
                <section id="multiple-column-form" class="input-validation">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitleThree']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        <form class="form-horizontal" action="{{route('addWalletBalance' , $editagent->id)}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            @method('POST')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="first-name-column">Wallet Amount</label>
                                                        <div class="form-label-group">
                                                            <input type="number" id="wallet_balance" class="form-control @error('wallet_balance') is-invalid @enderror" placeholder="Wallet Balance" name="wallet_balance" value="" autocomplete="off">
                                                            @error('wallet_balance')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="first-name-column">Description (optional)</label>
                                                        <div class="form-label-group">
                                                            <textarea type="number" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="description" name="description"autocomplete="off"></textarea>
                                                            @error('description')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div>&nbsp;</div>
                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Save
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
                @endcan --}}

                {{-- <section id="multiple-column-form" class="input-validation">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['subTitleFour']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        <form class="form"
                                              action="{{route('markups.update', $editmarkup->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">{{__('admin.fee_type')}}</label>
                                                        <div class="form-label-group">
                                                            
                                                            <select name="fee_type" class="form-control @error('fee_type') is-invalid @enderror">
                                                                <option value=""> select Fee type</option>
                                                                <option value="addition" {{$editmarkup->fee_type == 'addition' ? 'selected' : ''}}>{{ucfirst('addition')}}</option>
                                                                <option value="subtraction" {{$editmarkup->fee_type == 'subtraction' ? 'selected' : ''}}>{{ucfirst('subtraction')}}</option>
                                                                
                                                            </select>
                                                            @error('fee_type')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                           
                                                        </div>
                                                    </div>


                                                    

                                                   

                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">{{__('admin.fee_value')}}</label>
                                                        <div class="form-label-group">
                                                            
                                                            <select name="fee_value" class="form-control @error('fee_value') is-invalid @enderror">
                                                                <option value=""> select Fee Value</option>
                                                                <option value="fixed" {{$editmarkup->fee_value == 'fixed' ? 'selected' : ''}}>{{ucfirst('fixed')}}</option>
                                                                <option value="percentage" {{$editmarkup->fee_value == 'percentage' ? 'selected' : ''}}>{{ucfirst('percentage')}}</option>
                                                                
                                                            </select>
                                                            @error('fee_value')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">{{__('admin.fee_amount')}}</label>
                                                        <div class="form-label-group">
                                                        
                                                        <input type="number" id="fee_amount" class="form-control @error('fee_amount') is-invalid @enderror" placeholder="{{__('admin.fee_amount')}}" name="fee_amount"  autocomplete="off" value="{{$editmarkup->fee_amount}}">
                                                            @error('fee_amount')
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror 
                                                        </div>  
                                                    </div>
                                                </div>

                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('admin.update')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </section> --}}

                <!-- Adding Form Ends -->

            </div>
        </div>
    </div>

@endsection