@extends('front_end.layouts.master')
@section('content')

  <!-- Page Header
  ============================================= -->
  <section class="page-header page-header-dark bg-secondary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>{{__('lang.offer_details')}} </h1>
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
              <li class="breadcrumb-item"><a href="{{route('offers')}}">{{__('lang.offers')}} </a></li>
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
            <h2 class="title-blog text-7">{{$offer->name}}</h2>
            <ul class="meta-blog mb-4">
              <li><i class="fas fa-calendar-alt"></i> {{date('M d,Y', strtotime($offer->valid_upto))}}</li>
              <li><a href=""><i class="fas fa-user"></i> Admin</a></li>
              <li><a href="#comments"><i class="fas fa-comments"></i> 03</a></li>
            </ul>
            <img class="img-fluid" src="{{asset('uploads/offers/'.$offer->image)}}" alt="">
            <div class="card-body px-0 pb-0">
             {!! $offer->description !!}
            </div>
            <hr class="mb-4">
            
            <!-- Tags & Share Social
            ================================= -->
            {{-- <div class="row mb-3">
              <div class="col-lg-7 col-xl-8">
                <div class="tags text-center text-lg-start"> <a href="#">Tips</a> <a href="#">2021</a> <a href="#">Recharge</a> <a href="#">How To</a> <a href="#">Payment</a> </div>
              </div>
              <div class="col-lg-5 col-xl-4">
                <div class="d-flex flex-column">
                  <ul class="social-icons social-icons-colored justify-content-center justify-content-lg-end">
                    <li class="social-icons-facebook"><a data-bs-toggle="tooltip" href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="social-icons-twitter"><a data-bs-toggle="tooltip" href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                    <li class="social-icons-google"><a data-bs-toggle="tooltip" href="http://www.google.com/" target="_blank" title="Google"><i class="fab fa-google"></i></a></li>
                    <li class="social-icons-linkedin"><a data-bs-toggle="tooltip" href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                    <li class="social-icons-instagram"><a data-bs-toggle="tooltip" href="http://www.instagram.com/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                  </ul>
                </div>
              </div>
            </div> --}}
            
            <!-- Author
			================================= -->
            {{-- <div class="row g-0 bg-light rounded p-4 mb-4 text-center text-sm-start">
              <div class="col-12 col-sm-auto me-4 mb-2 mb-sm-0"> <img class="rounded" src="images/blog/author.jpg" alt=""> </div>
              <div class="col-12 col-sm">
                <h4 class="title-blog text-4 mb-2"><a href="#">Simone Olivia</a></h4>
                <p class="mb-2">Some quick example text to build on the card title and make up the bulk of the card's content to orem ipsum dolor sit amet, consectetur adipiscing elit, eiusmod tempor incididunt ut labore consectetur adipiscing incididunt.</p>
                <div class="d-flex flex-column">
                  <ul class="social-icons social-icons-sm social-icons-muted justify-content-center justify-content-sm-start">
                    <li class="social-icons-twitter"><a data-bs-toggle="tooltip" href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                    <li class="social-icons-facebook"><a data-bs-toggle="tooltip" href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="social-icons-linkedin"><a data-bs-toggle="tooltip" href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                  </ul>
                </div>
              </div>
            </div> --}}
            
            <!-- Related Posts
            ================================= -->
            {{-- <h5 class="mb-4 mt-3">Related Posts</h5>
            <div class="side-post">
              <div class="row">
                <div class="col-12 col-md-6 mb-3">
                  <div class="item-post">
                    <div class="img-thumb"><a href="blog-single.html"><img class="rounded" src="images/blog/post-5-65x65.jpg" title="" alt=""></a></div>
                    <div class="caption"> <a href="blog-single.html">How to start a mobile top-up recharge business?</a>
                      <p class="date-post">April 24, 2022</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <div class="item-post">
                    <div class="img-thumb"><a href="blog-single.html"><img class="rounded" src="images/blog/post-2-65x65.jpg" title="" alt=""></a></div>
                    <div class="caption"> <a href="blog-single.html">Staggering Sites to Visit Near United Airport to Break The Monotony</a>
                      <p class="date-post">April 24, 2022</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <div class="item-post">
                    <div class="img-thumb"><a href="blog-single.html"><img class="rounded" src="images/blog/post-3-65x65.jpg" title="" alt=""></a></div>
                    <div class="caption"> <a href="blog-single.html">Minimise Your Risk. Maximise Your Returns</a>
                      <p class="date-post">April 24, 2022</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <div class="item-post">
                    <div class="img-thumb"><a href="blog-single.html"><img class="rounded" src="images/blog/post-4-65x65.jpg" title="" alt=""></a></div>
                    <div class="caption"> <a href="blog-single.html">List of Countries Offering Visa on Arrival for Indians in 2021</a>
                      <p class="date-post">April 24, 2022</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr> --}}
            
            <!-- Comments
			================================= -->
            {{-- <h5 id="comments" class="mb-4 mt-3">Comments (03)</h5>
            <div class="post-comment">
              <ul>
                <li>
                  <div class="row">
                    <div class="col-auto pe-2"> <img class="rounded" alt="" src="images/blog/user-3.jpg"> </div>
                    <div class="col">
                      <h6> <a class="float-end text-2 text-muted btn-link" href="#"><span class="me-1"><i class="fas fa-reply-all"></i></span>Reply</a> Ruby Clinton <span class="text-muted text-2 fw-400 d-block d-sm-inline-block mt-2 mt-sm-0"><em>- April 15, 2022</em></span> </h6>
                      <p class="mb-0">Some quick example text to build on the card title and make up the bulk of the card's content to orem ipsum dolor sit amet, consectetur adipiscing elit, eiusmod tempor incididunt ut labore. Lorem ipsum dolor sit amet, consectetur adipiscing incididunt.</p>
                    </div>
                  </div>
                  <ul>
                    <li>
                      <div class="row">
                        <div class="col-auto pe-2"> <img class="rounded" alt="" src="images/blog/user-1.jpg"> </div>
                        <div class="col">
                          <h6> <a class="float-end text-2 text-muted btn-link" href="#"><span class="me-1"><i class="fas fa-reply-all"></i></span>Reply</a> James Maxwell <span class="text-muted text-2 fw-400 d-block d-sm-inline-block mt-2 mt-sm-0"><em>- April 18, 2022</em></span> </h6>
                          <p class="mb-0">Some quick example text to build on the card title and make up the bulk of the card's content to orem ipsum dolor sit amet, consectetur adipiscing elit, eiusmod tempor incididunt ut labore.</p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
                <li>
                  <div class="row">
                    <div class="col-auto pe-2"> <img class="rounded" alt="" src="images/blog/user-2.jpg"> </div>
                    <div class="col">
                      <h6> <a class="float-end text-2 text-muted btn-link" href="#"><span class="me-1"><i class="fas fa-reply-all"></i></span>Reply</a> Neil Patel <span class="text-muted text-2 fw-400 d-block d-sm-inline-block mt-2 mt-sm-0"><em>- March 22, 2022</em></span> </h6>
                      <p class="mb-0">Some quick example text to build on the card title and make up the bulk of the card's content to orem ipsum dolor sit amet, consectetur adipiscing elit, eiusmod tempor incididunt ut labore. Lorem ipsum dolor sit amet, consectetur adipiscing incididunt.</p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <hr class="my-4"> --}}
            <!-- Write a Comment
			================================= -->
            {{-- <h5 class="mb-4 mt-3">Write a Comment</h5>
            <form method="post">
              <div class="row g-3">
                <div class="col-12 col-md-4">
                  <label class="form-label" for="yourName">Name</label>
                  <input type="text" class="form-control" id="yourName" required aria-describedby="yourName" placeholder="Your Name">
                </div>
                <div class="col-12 col-md-4">
                  <label class="form-label" for="yourEmail">Email</label>
                  <input type="email" class="form-control" id="yourEmail" required aria-describedby="yourName" placeholder="Your Email">
                </div>
                <div class="col-12 col-md-4">
                  <label class="form-label" for="yourWebsite">Website</label>
                  <input type="text" class="form-control" id="yourWebsite" aria-describedby="yourName" placeholder="Your Website">
                </div>
                <div class="col-12">
                  <label class="form-label" for="yourComment">Your Comment</label>
                  <textarea class="form-control" rows="4" id="yourComment" required placeholder="Your Comment"></textarea>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form> --}}
          </div>
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