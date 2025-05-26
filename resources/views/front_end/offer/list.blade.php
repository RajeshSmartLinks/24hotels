@extends('front_end.layouts.master')
@section('content')
  
  <!-- Page Header
  ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.offers')}} </h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">{{__('lang.home')}}</a></li>
            <li class="active">{{__('lang.offers')}} </li>
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
        
        <!-- Middle Panel
        ============================================= -->
        <div class="col-lg-8 col-xl-9">
          <div class="row g-4">
            @foreach($offers as $offer)
            <div class="col-md-6">
              <div class="blog-post card shadow-sm border-0 h-100"> <a href="{{route('offerDetails',['slug'=>$offer->slug])}}"><img class="card-img-top d-block" src="{{asset('uploads/offers/'.$offer->image)}}" alt="" height="210"></a>
                <div class="card-body p-4">
                  <h4 class="title-blog text-5 offerList"><a href="{{route('offerDetails',['slug'=>$offer->slug])}}" >{{$offer->name}}</a></h4>
                  <ul class="meta-blog">
                    <li><i class="fas fa-calendar-alt"></i> {{date('M d,Y', strtotime($offer->valid_upto))}}</li>
                  
                  </ul>
                  <p>{!! substr($offer->description,0,201)!!}
                    @if(strlen($offer->description)>201)
                    ....
                    @endif
                  </p>
                  <a href="{{route('offerDetails',['slug'=>$offer->slug])}}" class="btn btn-primary btn-sm">{{__('lang.read_more')}}</a> </div>
              </div>
            </div>
            @endforeach
          </div>
       
  
          
          <!-- Pagination
          ============================================= -->
          <ul class="pagination justify-content-center mt-4 mb-5">
            {{ $offers->links() }}
          </ul>
          <!-- Paginations end --> 
          
        </div>
        <!-- Middle Panel End --> 
        
        <!-- Right Sidebar
        ============================================= -->
        <aside class="col-lg-4 col-xl-3"> 
          <div class="bg-white shadow-sm rounded p-3 mb-4">
            <h4 class="text-5">{{__('lang.recent_offers')}}</h4>
            <hr class="mx-n3">
            <div class="side-post">
              @foreach($offers as $item)
                <div class="item-post">
                  <div class="img-thumb"><a href="{{route('offerDetails',['slug'=>$item->slug])}}"><img class="rounded" src="{{asset('uploads/offers/'.$item->image)}}" title="" alt="" style="height: 70px;width: 60px;
                  s"></a></div>
                  <div class="caption"> <a style="overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;" href="{{route('offerDetails',['slug'=>$item->slug])}}">{{$item->name}}</a>
                    <p class="date-post">{{date('M d,Y', strtotime($item->valid_upto))}}</p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="bg-white shadow-sm rounded p-3 mb-4">
            <h4 class="text-5">{{__('lang.recent_packages')}} </h4>
            <hr class="mx-n3">
            <div class="side-post">
              @foreach($packages as $item)
                <div class="item-post">
                  <div class="img-thumb"><a href="{{route('packageDetails',['slug'=>$item->slug])}}"><img class="rounded" src="{{asset('uploads/packages/'.$item->image)}}" title="" alt="" style="height: 70px;width: 60px;"></a></div>
                  <div class="caption"> <a style="overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;" href="{{route('packageDetails',['slug'=>$item->slug])}}">{{$item->name}}</a>
                    {{-- <p class="date-post">{{date('M d,Y', strtotime($item->valid_upto))}}</p> --}}
                  </div>
                </div>
              @endforeach
            </div>
          </div>
         
          
        </aside>
        <!-- Right Sidebar End --> 
        
      </div>
    </div>
  </div>
  <!-- Content end --> 
  
  @endsection