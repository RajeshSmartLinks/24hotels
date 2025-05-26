@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>500 - Intenal server error</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">Home</a></li>
            <li class="active">500 - intenal server error</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Page Header end --> 
  
  <!-- Content
  ============================================= -->
  <div id="content"> 
    <!-- 404
    ============================================= -->
    <section class="section">
      <div class="container text-center">
        @if(isset($data['errorresponse']))
        <p class="text-3 text-muted">{{$data['errorresponse']}}</p>
        @else
        <h2 class="text-25 fw-600 mb-0">500</h2>
        <h3 class="text-6 fw-600 mb-3">Whoops, looks like something went wrong on our servers</h3>
        {{-- <p class="text-3 text-muted">The page you are looking for was moved, removed, renamed , might never existed or session expired.</p> --}}
        @endif
        <a href="{{url('/')}}" class="btn btn-primary shadow-none px-5 m-2">Home</a>  </div>
    </section>
    <!-- 404 end --> 
    
  </div>
  <!-- Content end --> 

@endsection