@extends('front_end.layouts.master')
@section('content')

<!-- Page Header
============================================= -->
<section class="page-header page-header-dark bg-secondary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>Agents List</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{{Url('/')}}">Home</a></li>
          <li class="active">Agents List</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- Page Header end --> 

<!-- Content
============================================= -->
<div id="content">
  <div class="container">
    <div class="row">
        @include('front_end.user.user_menu')
      <div class="col-lg-10">
        <div class="bg-white shadow-md rounded p-4"> 
          <!-- Orders History
          ============================================= -->
          <h4 class="mb-4">Agents</h4>
          
		      <hr class="mx-n4">
         
   
          <div class="tab-content my-3" id="myTabContent">
            @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
              {{ Session::get('success') }}
            </div>
            @endif
            @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
              {{ Session::get('error') }}
            </div>
            @endif
            @can('agent-add')
            <div style="float: right;padding: 10px">
                <a href="{{route('add-sub-agent')}}" class="btn btn-primary btn-sm">Add Agent</a>
            </div>
            @endcan
          
         
            
            <div class="tab-pane fade show active" id="third" role="tabpanel" aria-labelledby="third-tab">
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead>
                    <tr>
                      <th>Agent Code</th>
                      <th>First name </th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Created On</th>
                      @can('agent-edit')
                      <th class="text-center">Action</th>
                      @endcan
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($agents) > 0)
                        @foreach($agents as $agent)
                        <tr>
                          <td class="align-middle"><strong>{{$agent->agent_code ?? '-'}}</strong></td>
                          <td class="align-middle">{{$agent->first_name}}</td>
                          <td class="align-middle">{{$agent->last_name}}</td>
                          <td class="align-middle">{{$agent->email}}</td>
                          <td class="align-middle"><span class="badge bg-info text-dark">{{$agent->hisRole() ?? 'Agent'}}</span></td>
                          <td class="align-middle text-center">{{$agent->status}}</td>
                          <td class="align-middle text-center"> {{$agent->created_at->format('d/m/Y')}}</td>
                          @can('agent-edit')
                          <td class="align-middle text-center">
                            <a href="{{route('edit-sub-agent', $agent->id)}}" class="text-primary" data-bs-toggle="tooltip" title="Edit Agent">
                              <i class="fas fa-edit"></i>
                            </a>
                          </td>
                          @endcan
                        </tr>
                        @endforeach
                    @else
                        <tr align="center" class="alert alert-danger">
                            <td colspan="{{ auth()->user()->can('agent-edit') ? 8 : 7 }}">{{__('lang.no_records')}}</td>
                        </tr>
                    @endif
                   
                  </tbody>
                </table>
                {{ $agents->links() }}
              </div>
            </div>
          </div>
          <!-- Orders History end --> 
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 

  


@endsection
