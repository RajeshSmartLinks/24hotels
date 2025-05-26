<!-- Footer
    ============================================= -->
    <footer id="footer">
      <section class="section bg-white shadow-md pt-4 pb-3">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-md-3">
              <div class="featured-box text-center">
                <div class="featured-box-icon"> <i class="fas fa-lock"></i> </div>
                <h4>{{__('lang.secure_payments')}}</h4>
                <p>{{__('lang.moving_your_card_desc')}}</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="featured-box text-center">
                <div class="featured-box-icon"> <i class="fas fa-thumbs-up"></i> </div>
                <h4>{{__('lang.trust_pay')}}</h4>
                <p>{{__('lang.trust_pay_desc')}}</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="featured-box text-center">
                <div class="featured-box-icon"> <i class="fas fa-bullhorn"></i> </div>
                <h4>{{__('lang.great_deals')}}</h4>
                <p>{{__('lang.great_deals_desc')}}</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="featured-box text-center">
                <div class="featured-box-icon"> <i class="far fa-life-ring"></i> </div>
                <h4>{{__('lang.24X7_support')}}</h4>
                <p>{{__('lang.24X7_support_desc')}}<a href="#">{{__('lang.click_here')}}</a></p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="container mt-4">
        <div class="row g-4">
          <div class="col-md-5">
            <p>{{__('lang.payment')}}</p>
            <ul class="payments-types">
              <li><a href="#" target="_blank"> <img data-bs-toggle="tooltip" src='{{asset("frontEnd/images/payment/visa.png")}}' alt="visa" title="Visa"></a></li>
              <li><a href="#" target="_blank"> <img data-bs-toggle="tooltip" src='{{asset("frontEnd/images/payment/discover.png")}}' alt="discover" title="Discover"></a></li>
              <li><a href="#" target="_blank"> <img data-bs-toggle="tooltip" src='{{asset("frontEnd/images/payment/paypal.png")}}' alt="paypal" title="PayPal"></a></li>
              <li><a href="#" target="_blank"> <img data-bs-toggle="tooltip" src='{{asset("frontEnd/images/payment/american.png")}}' alt="american express" title="American Express"></a></li>
              <li><a href="#" target="_blank"> <img data-bs-toggle="tooltip" src='{{asset("frontEnd/images/payment/mastercard.png")}}' alt="discover" title="Discover"></a></li>
            </ul>
          </div>
          <div class="col-md-3">
            {{-- <p>Subscribe</p>
            <div class="input-group newsletter">
              <input class="form-control" placeholder="Your Email Address" name="newsletterEmail" id="newsletterEmail" type="text">
              <button class="btn btn-secondary shadow-none px-3" type="submit">Subscribe</button>
            </div> --}}
            <div class="row">
							<div class="col-6">
								<div class="reg-div" style="right:10px;">
								<img src="{{asset("frontEnd/images/iata.png")}}" style="width: 80px;height: 55px;" alt="Image Alternative text" title="IATA">
								<h6 class="text-black">42213253</h6>
								</div>
							</div>
							<div class="col-6">
								<div class="reg-div" style="left:10px;">
								<img src="{{asset("frontEnd/images/civil-aviation.png")}}" style="width: 130px;height: 55px;" alt="Image Alternative text" title="Kuwait-Civil">
								<h6 class="text-black" style="text-align: center;">2016/1925</h6>
								</div>
							</div>
						</div>
          </div>
          <div class="col-md-4 d-flex align-items-md-end flex-column">
            <p>{{__('lang.keep_in_touch')}}</p>
            <ul class="social-icons social-icons-colored">
              
              <li class="social-icons-facebook"><a data-bs-toggle="tooltip" href="https://www.facebook.com/24Flights" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
              <li class="social-icons-twitter"><a data-bs-toggle="tooltip" href="https://twitter.com/24Flights" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
              {{-- <li class="social-icons-google"><a data-bs-toggle="tooltip" href="http://www.google.com/" target="_blank" title="Google"><i class="fab fa-google"></i></a></li> --}}
              {{-- <li class="social-icons-linkedin"><a data-bs-toggle="tooltip" href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li> --}}
              <li class="social-icons-youtube"><a data-bs-toggle="tooltip" href="https://www.youtube.com/@24flights59/" target="_blank" title="Youtube"><i class="fab fa-youtube"></i></a></li>
              <li class="social-icons-instagram"><a data-bs-toggle="tooltip" href="https://www.instagram.com/24_flights/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="footer-copyright">
          <ul class="nav justify-content-center">
            <li class="nav-item"> <a class="nav-link active" href="#">{{__('lang.about_us')}}</a> </li>
            <li class="nav-item"> <a class="nav-link" href="{{route('faq')}}">{{__('lang.faq')}}</a> </li>
            <li class="nav-item"> <a class="nav-link" href="{{route('contactUs')}}">{{__('lang.contact')}}</a> </li>
            <li class="nav-item"> <a class="nav-link" href="https://api.whatsapp.com/send?phone=96567041515" target="_blank">{{__('lang.support')}}</a> </li>
            <li class="nav-item"> <a class="nav-link" href="{{route('TermsOfUse')}}">{{__('lang.terms_of_use')}}</a> </li>
            <li class="nav-item"> <a class="nav-link" href="{{route('PrivacyPolicy')}}">{{__('lang.privacy_policy')}}</a> </li>
          </ul>
          <p class="copyright-text">Al Masila Group Initiative | ©{{date('Y')}} {{__('lang.reserved_by')}}  <a href="{{url('/')}}">{{env('APP_NAME')}}</a>® | {{__('lang.powered_by')}} <a href="https://smartlinks.tech/">SmartLinks</a></p>
        </div>
      </div>
    </footer>
    <!-- Footer end --> 