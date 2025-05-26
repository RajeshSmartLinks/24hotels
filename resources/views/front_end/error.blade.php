@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>404 - Page not found</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="index.html">Home</a></li>
            <li class="active">404 - Page Not Found</li>
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
        <h2 class="text-25 fw-600 mb-0">404</h2>
        <h3 class="text-6 fw-600 mb-3">oops! The page you requested was not found!</h3>
        <p class="text-3 text-muted">The page you are looking for was moved, removed, renamed , might never existed or session expired.</p>
        @endif
        <a href="{{url('/')}}" class="btn btn-primary shadow-none px-5 m-2">Home</a> <a href="{{url('/')}}" class="btn btn-outline-dark shadow-none px-5 m-2">Back</a> </div>
    </section>
    <!-- 404 end --> 
    
  </div>
  <!-- Content end --> 

@endsection