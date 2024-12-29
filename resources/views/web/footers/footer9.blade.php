<style>
.btn-whatsapp-pulse {
	 
	position: fixed;
	 
	font-size: 100px;
	display: flex;
	justify-content: center;
	align-items: center;
	width: 0;
	height: 0;
	padding: 25px;
	text-decoration: none;
	border-radius: 50%;
	z-index:9999999;
	 
}
 
.btn-whatsapp-pulse-border {
	bottom: 100px;
	right: 66px;
	 
}
 
@keyframes pulse-border {
	0% {
		padding: 25px;
		opacity: 0.75;
	}
	75% {
		padding: 50px;
		opacity: 0;
	}
	100% {
		opacity: 0;
	}
}

</style>
 
 <a href="https://wa.me/+919281041589" class="btn-whatsapp-pulse btn-whatsapp-pulse-border" style="color:black">
 	<img src="{{asset('images/whatsappgiff.gif')}}" alt="Whatsappicon" height="60">
</a>
 
<!-- //footer style Nine   -->
<footer id="footerNine"  class="footer-area footer-nine footer-dark footer-desktop d-none d-lg-block d-xl-block">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-2">
              <div class="row">
                 
                    <div class="footer-image mb-4">
                      <h5>@lang('website.DOWNLOAD OUR APP')</h5>
                      <a href="{{$result['commonContent']['setting'][109]->value}}"><img class="img-fluid" src="{{asset('images/google_playstore.png')}}"></a>
                     </div>
                     
                 
                 
              </div>
          </div>
          <div class="col-12 col-md-6 col-lg-10">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-2">
                <div class="single-footer single-footer-left">
                  <h5>@lang('website.Our Services')</h5>
                  
                  <ul class="links-list pl-0 mb-0">
                    <li> <a href="{{ URL::to('/')}}"><i class="fa fa-angle-right"></i>@lang('website.Home')</a> </li>
                    <li> <a href="{{ URL::to('/aboutus')}}"><i class="fa fa-angle-right"></i>About Us</a> </li>
                    <li> <a href="{{ URL::to('/careers')}}"><i class="fa fa-angle-right"></i>Careers</a> </li>
                    <li> <a href="{{ URL::to('/contact')}}"><i class="fa fa-angle-right"></i>@lang('website.Contact Us')</a> </li>
                    <li> <a href="{{ URL::to('/orders')}}"><i class="fa fa-angle-right"></i>@lang('website.Orders')</a> </li>
                    <li> <a href="{{ URL::to('/wishlist')}}"><i class="fa fa-angle-right"></i>@lang('website.Wishlist')</a> </li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-3">
                <h5>Our Policies</h5>
                
                <ul class="links-list pl-0 mb-0">
                  @if(count($result['commonContent']['pages']))
                      @foreach($result['commonContent']['pages'] as $page)
                          <li> <a href="{{ URL::to('/page?name='.$page->slug)}}"><i class="fa fa-angle-right"></i>{{$page->name}}</a> </li>
                      @endforeach
                  @endif
                     </ul>
              </div>
              <div class="col-12 col-lg-3">
                  <h5>@lang('website.Contact Us')</h5>
                  
                  <ul class="contact-list  pl-0 mb-0">
                    <li> <i class="fas fa-map-marker"></i><span>BMLED & BUILDER MART INDIA PRIVATE LIMITED <br>{{$result['commonContent']['setting'][4]->value}} {{$result['commonContent']['setting'][5]->value}} {{$result['commonContent']['setting'][6]->value}}, {{$result['commonContent']['setting'][7]->value}} {{$result['commonContent']['setting'][8]->value}}</span> </li>
                    <li> <i class="fas fa-phone"></i><span dir="ltr">({{$result['commonContent']['setting'][11]->value}})</span> </li>
                    <li> <i class="fas fa-envelope"></i><span> <a href="mailto:{{$result['commonContent']['setting'][3]->value}}">{{$result['commonContent']['setting'][3]->value}}</a> </span> </li>
                  </ul>

              </div>
              <div class="col-12 col-lg-4">
              <h5>Headquarters</h5>
              <ul class="contact-list  pl-0 mb-0">
                <li> 
                
                <i class="fas fa-map-marker"></i><span> {{$result['commonContent']['setting'][49]->value}} <br>  {{$result['commonContent']['setting'][130]->value}}  </span> </li>
                 <li> <i class="fas fa-phone"></i><span>   {{$result['commonContent']['setting'][132]->value}}  </span> </li>
             
              
              <li> <i class="fas fa-envelope"></i><span> {{$result['commonContent']['setting'][131]->value}}<a href="mailto:{{$result['commonContent']['setting'][133]->value}}">{{$result['commonContent']['setting'][133]->value}}</a> </span> </li>
              </ul>
              </div>
            </div>

          </div>

        </div>

      </div>
      <div class="container-fluid p-0">
        <div class="social-content">
            <div class="container">
              <div class="social-div">
                <div class="row align-items-center justify-content-between">
                  
                  <div class="col-12 col-md-4">
                        
                        <div class="footer-info">
                           Â© @lang('website.Copy Rights').  <a href="{{url('/page?name=refund-policy')}}">@lang('website.Privacy')</a>&nbsp;&bull;&nbsp;<a href="{{url('/page?name=term-services')}}">@lang('website.Terms')</a>
                        </div>
                  </div>
                  <div class="col-12 col-md-4">
                          <ul class="social">
                              <li>
                                @if(!empty($result['commonContent']['setting'][50]->value))
                                  <a href="{{$result['commonContent']['setting'][50]->value}}" class="fab fa-facebook-f" target="_blank"></a>
                                  @else
                                    <a href="#" class="fab fa-facebook-f"></a>
                                  @endif
                              </li>
                              <li>
                              @if(!empty($result['commonContent']['setting'][52]->value))
                                  <a href="{{$result['commonContent']['setting'][52]->value}}" class="fab fa-twitter" target="_blank"></a>
                              @else
                                  <a href="#" class="fab fa-twitter"></a>
                              @endif</li>
                              <li>
                              @if(!empty($result['commonContent']['setting'][51]->value))
                                  <a href="{{$result['commonContent']['setting'][51]->value}}"  target="_blank"><i class="fab fa-google"></i></a>
                              @else
                                  <a href="#"><i class="fab fa-google"></i></a>
                              @endif
                              </li>
                              <li>
                              @if(!empty($result['commonContent']['setting'][53]->value))
                                  <a href="{{$result['commonContent']['setting'][53]->value}}" class="fab fa-linkedin-in" target="_blank"></a>
                              @else
                                  <a href="#" class="fab fa-linkedin-in"></a>
                              @endif
                              </li>

                          </ul>
                  </div>
                </div>
            </div>
            </div>  
        </div>
    </div>
</footer>