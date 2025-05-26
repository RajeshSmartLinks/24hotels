@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
    ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.faq')}} </h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}} </a></li>
            <li class="active">{{__('lang.faq')}} </li>
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
      <div class="bg-white shadow-md rounded p-4">
        <h3 class="text-6 mb-4">{{__('lang.get_answers_to_your_queries')}} </h3>
        <hr class="mx-n4 mb-4">
        <div class="row">
          
          <div class="col-md-12">
            <div class="accordion accordion-flush" id="accordion">
                @foreach ($faqs as $item)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading1">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{$loop->index}}" aria-expanded="false" aria-controls="faq{{$loop->index}}">{{$item->question}}</button>
                    </h2>
                    <div id="faq{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#accordion">
                      <div class="accordion-body"> {!! $item->answer !!}</div>
                    </div>
                  </div>
                @endforeach
              
             
            </div>
          </div>
        </div>
        <hr>
      
        <div class="text-center my-3 my-md-5">
          <p class="text-4 mb-3">{{__('lang.faq_des')}}</p>
          <a href="https://api.whatsapp.com/send?phone=96567041515" class="btn btn-primary">{{__('lang.contact_customer_care')}}</a> </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
  
  @endsection