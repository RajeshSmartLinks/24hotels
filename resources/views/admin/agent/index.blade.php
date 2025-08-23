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
                                    @can('agent-add')
                                    <a href="{{route('agents.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light"><i class="feather icon-plus-circle"></i>&nbsp;Add Agent</a>
                                    @endcan
                                </div>
                               
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    {{-- <th>Wallet</th> --}}
                                                    <th>Agency</th>
                                                    
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($agents) > 0)
                                                    @foreach($agents as $agent)
                                                        <tr>
                                                            <td>{{$agent->first_name}} {{$agent->last_name}} </td>
                                                            <td>{{$agent->agency->name ?? ''}}</td>
                                                            <td>{{$agent->email}}</td>
                                                            <td>
                                                                
                                                                @can('agent-edit')
                                                                    <a href="{{ route('agents.edit', $agent->id) }}"><i
                                                                            class="feather icon-edit"></i> Edit</a>
                                                                @endcan
                                                                @can('agent-view')
                                                                    | <a  class="text-success" href="{{ route('agents.view', ['id' => $agent->id]) }}"><i
                                                                            class="feather icon-eye"></i> View</a>
                                                                @endcan

                                                                @can('agent-delete')
                                                                    | <a href="javascript:" class="text-danger deleteBtn"
                                                                       onclick="destroy({{$agent->id}})"
                                                                       data-id="{{$agent->id}}"
                                                                       data-toggle="modal"
                                                                       data-target="#deleteModal" id="deleteBtn"><i
                                                                            class="feather icon-trash"></i> Delete</a>
                                                                @endcan
                                                               {{-- @can('agent-add-credit')
                                                                | <a href="javascript:" class="text-warning addFundsBtn"
                                                                    onclick="addFundsToWallet({{$agent->id}} , '{{$agent->first_name . ' ' . $agent->last_name}}')"
                                                                    data-id="{{$agent->id}}"
                                                                    data-toggle="modal"
                                                                    data-target="#addFunds" id="addFundsBtn"><i
                                                                        class="feather icon-briefcase"></i> Add Funds</a> 
                                                                @endcan --}}
                                                                 {{-- @can('markups-edit')
                                                                | <a href="javascript:" class="text-info agentMarkUpBtn"
                                                                    onclick="agentMarkUpUpdate({{$agent->agentMarkup->id ?? ''}} , '{{$agent->first_name . ' ' . $agent->last_name}}' ,'{{$agent->agentMarkup->fee_amount ?? 0}}' , '{{$agent->agentMarkup->fee_value ?? ''}}','{{$agent->agentMarkup->fee_type ?? ''}}' , {{$agent->agentHotelMarkup->id ?? ''}} , '{{$agent->agentHotelMarkup->fee_amount ?? 0}}' , '{{$agent->agentHotelMarkup->fee_value ?? ''}}','{{$agent->agentHotelMarkup->fee_type ?? ''}}' )"
                                                                    data-id="{{$agent->id}}"
                                                                    data-toggle="modal"
                                                                    data-target="#agentMarkUp" id="agentMarkUpBtn"><i
                                                                        class="feather icon-dollar-sign"></i> MarkUps</a> 
                                                                @endcan --}}
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
    {{-- {{ dd(route($agentMarkUpRoute, ":id"))}} --}}
    <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal>
    <x-add-funds :routename="$addingFunds"></x-add-funds>
    <x-agent-markup :routename="$agentMarkUpRoute"></x-agent-markup>

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
            let url = '{{ route("agents.destroy", ":id") }}';
            url = url.replace(':id', delId);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(delId);
        }

        function addFundsToWallet(agentId,name){
            let url = '{{ route("addWalletBalance", ":id") }}';
            url = url.replace(':id', agentId);
            $("#addFundsForm").attr('action', url);
            $("#agent_name").html(name);
        }

        function agentMarkUpUpdate(markup_id,name ,feeAmount, feeValue ,feeType ,hotelMarkupid,hotelFeeAmount,hotelFeeValue,hotelFeeType){
            let agentMarkUpRoute = @json(route($agentMarkUpRoute, ':id'));
            let url = agentMarkUpRoute.replace(':id', markup_id);
            url = url.replace(':id', markup_id);
            $("#agentMarkUpForm").attr('action', url);
            $("#markup_agent_name").html(name);

            // Populate form fields with the provided data flight
            $('#markup_id').val(markup_id);
            $('#fee_amount').val(feeAmount);
            $('select[name="fee_value"]').val(feeValue);
            $('select[name="fee_type"]').val(feeType);

            // Populate form fields with the provided data hotel
            $('#hotel_markup_id').val(hotelMarkupid);
            $('#hotel_fee_amount').val(hotelFeeAmount);
            $('select[name="hotel_fee_value"]').val(hotelFeeValue);
            $('select[name="hotel_fee_type"]').val(hotelFeeType);


        }

        
     
    </script>
@endsection