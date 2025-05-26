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
                                      
                                      

                                        <form class="form"
                                              action="{{route('hotelupdateadditionalPrice', $editPrices->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Currency Code</label>
                                                        <input type="text" id="currency_code" class="form-control"  autocomplete="off" value="{{$editPrices->currency_code}}" readonly>
                                                            
                                                            
                                                    </div>
                                                   
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Service Fee</label>
                                                        <input type="number" id="additional_price" class="form-control  @error('additional_price') is-invalid @enderror"  name="additional_price"  autocomplete="off" value="{{$editPrices->additional_price}}" >
                                                        @error('additional_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                            
                                                    </div>

                                                   

                                                 
                                                    
                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Credit Card Percentage</label>
                                                        <input type="number" id="credit_card_percentage" class="form-control"  autocomplete="off" value="{{$editPrices->credit_card_percentage}}" name="credit_card_percentage" >
                                                        @error('credit_card_percentage')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                            
                                                            
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <label for="first-name-column">Wallet Price</label>
                                                        <input type="number" id="wallet_price" class="form-control"  autocomplete="off" value="{{$editPrices->wallet_price}}" name="wallet_price" >
                                                        @error('wallet_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                   
                                                    <div class="col-md-6 col-12">
                                                        {{-- <div class="form-label-group"> --}}
                                                            <label for="first-name-column">status</label>
                                                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                                                <option value=""> select Fee Value</option>
                                                                <option value="Active" {{$editPrices->status == 'Active' ? 'selected' : ''}}>{{ucfirst('Active')}}</option>
                                                                <option value="InActive" {{$editPrices->status == 'InActive' ? 'selected' : ''}}>{{ucfirst('InActive')}}</option>
                                                                
                                                            </select>
                                                            @error('status')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        {{-- </div> --}}
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
                </section>

                <!-- Adding Form Ends -->

            </div>
        </div>
    </div>

@endsection

@section('scripts')
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
