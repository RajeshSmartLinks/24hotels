@extends('front_end.layouts.master')
@section('content')

  <!-- Page Header
  ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.package_details')}} </h1>
        </div>
        <div class="col-md-4">
          {{-- <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="{{route('offers')}}">Offers</a></li>
            <li class="active">Details</li>
          </ul> --}}
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-md-end mb-0">
              <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('lang.home')}} </a></li>
              <li class="breadcrumb-item"><a href="#">{{__('lang.packages')}} </a></li>
              <li class="breadcrumb-item active">{{__('lang.details')}}</li>
            </ol>
          </nav>
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
          <div class="blog-post card shadow-sm border-0 mb-4 p-4">
            <h2 class="title-blog text-7">{{$package->name}}</h2>
            <ul class="meta-blog mb-4">
              {{-- <li><i class="fas fa-calendar-alt"></i> {{date('M d,Y', strtotime($package->valid_upto))}}</li>
              <li><a href=""><i class="fas fa-user"></i> Admin</a></li>
              <li><a href="#comments"><i class="fas fa-comments"></i> 03</a></li> --}}
            </ul>
            <img class="img-fluid" src="{{asset('uploads/packages/'.$package->image)}}" alt="">
            <div class="card-body px-0 pb-0">
             {!! $package->description !!}
            </div>
            <hr class="mb-4">
            <div class="text-center"> 
              <?php $whatsAppNumber = !empty($package->whatsapp_number)?$package->whatsapp_number:'96567041515';?>
              <a class="btn btn-primary mx-2" href="https://api.whatsapp.com/send?phone={{$whatsAppNumber}}" target="_blank">Enquiry</a>
            </div>
          </div>
        </div>
        <!-- Middle Panel End --> 
        
        <!-- Right Sidebar
        ============================================= -->
        <aside class="col-lg-4 col-xl-3"> 
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
          
        </aside>
        <!-- Right Sidebar End --> 
        
      </div>
    </div>
  </div>
  <!-- Content end --> 
  
@endsection