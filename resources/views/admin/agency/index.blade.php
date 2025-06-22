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
                <!-- List Datatable Starts -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titles['listTitle']}}</h4>
                                    @can('offer-add')
                                    <a href="{{route('agency.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light"><i class="feather icon-plus-circle"></i>&nbsp;Add Agency</a>
                                    @endcan
                                </div>
                               
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Logo</th>
                                                    <th>Phone Number</th>
                                                    <th>status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($agencies) > 0)
                                                    @foreach($agencies as $agency)
                                                        <tr>
                                                            <td>{{$agency->name}} </td>
                                                             <td class="product-img"><img
                                                                    src="{{$agency->logo ?  asset('uploads/agency/'.$agency->logo) : $noImage}} "
                                                                    width="50"/>
                                                            </td>
                                                            <td>{{$agency->country->phone_code}} &nbsp; {{$agency->phone_number}} </td>
                                                            <td>{{$agency->status}} </td>
                                                            {{-- <td class="product-img"><img
                                                                    src="{{$brand->image ?  asset('uploads/brand/'.$brand->image) : $noImage}} "
                                                                    width="50"/></td> --}}
                                                            <td>
                                                                @can('agency-edit')
                                                                    <a href="{{ route('agency.edit', $agency->id) }}"><i
                                                                            class="feather icon-edit"></i> Edit</a> |
                                                                @endcan

                                                                @can('agency-delete')
                                                                    <a href="javascript:" class="text-danger deleteBtn"
                                                                       onclick="destroy({{$agency->id}})"
                                                                       data-id="{{$agency->id}}"
                                                                       data-toggle="modal"
                                                                       data-target="#deleteModal" id="deleteBtn"><i
                                                                            class="feather icon-trash"></i> Delete</a>
                                                                @endcan

                                                                @can('agent-add-credit')
                                                                | <a href="javascript:" class="text-warning addFundsBtn"
                                                                    onclick="addFundsToWallet({{$agency->id??''}} , '{{$agency->name ?? ''}}')"
                                                                    data-id="{{$agency->id}}"
                                                                    data-toggle="modal"
                                                                    data-target="#addFunds" id="addFundsBtn"><i
                                                                        class="feather icon-briefcase"></i> Add Funds</a> 
                                                                @endcan
                                                                @can('markups-edit')
                                                                | <a href="javascript:" class="text-info agentMarkUpBtn"
                                                                    onclick="agencyMarkUpUpdate( '{{$agency->name}}' , {{$agency->masterAgent->agencyMasterAgentHotelmarkups->id ?? ''}} , '{{$agency->masterAgent->agencyMasterAgentHotelmarkups->fee_amount ?? 0}}' , '{{$agency->masterAgent->agencyMasterAgentHotelmarkups->fee_value ?? ''}}','{{$agency->masterAgent->agencyMasterAgentHotelmarkups->fee_type ?? ''}}' )"
                                                                    
                                                                    data-toggle="modal"
                                                                    data-target="#agentMarkUp" id="agentMarkUpBtn"><i
                                                                        class="feather icon-dollar-sign"></i> MarkUps</a> 
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
    <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal>
    <x-add-agency-funds :routename="$addingFunds"></x-add-agency-funds>
    <x-agency-markup :routename="$agencyMarkUpRoute"></x-agency-markup>

@endsection


@section('extrascript')
    <script>
        $('.zero-configuration').DataTable(
            {
                "displayLength": 50,
            }
        );

        @if(session('success'))
        toastr.success('{{session('success')}}', 'success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'error');
        @endif

        // Functionality section
        function destroy(delId) {
            let url = '{{ route("agency.destroy", ":id") }}';
            url = url.replace(':id', delId);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(delId);
        }
         function addFundsToWallet(agencyId,agencyName){
            let url = '{{ route("addAgencyWalletBalance", ":id") }}';
            url = url.replace(':id', agencyId);
            $("#addFundsForm").attr('action', url);
            $("#agency_name").html(agencyName);
        }

        function agencyMarkUpUpdate(agencyname,hotelMarkupid,hotelFeeAmount,hotelFeeValue,hotelFeeType){
            let agencyMarkUpRoute = @json(route($agencyMarkUpRoute, ':id'));
            let url = agencyMarkUpRoute.replace(':id', hotelMarkupid);
            url = url.replace(':id', hotelMarkupid);
            $("#agencyAgentMarkUpForm").attr('action', url);
            $("#markup_agency_name").html(agencyname);

            // Populate form fields with the provided data hotel
            $('#hotel_markup_id').val(hotelMarkupid);
            $('#hotel_fee_amount').val(hotelFeeAmount);
            $('select[name="hotel_fee_value"]').val(hotelFeeValue);
            $('select[name="hotel_fee_type"]').val(hotelFeeType);


        }

      
    </script>
@endsection