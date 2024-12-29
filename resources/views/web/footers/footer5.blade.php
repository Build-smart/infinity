<!-- //footer style Five  -->

<footer id="footerFive"  class="footer-area footer-nine footer-desktop d-none d-lg-block d-xl-block pro-content">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 col-lg-2">
          <div class="row">
            <div class="col-12">
            
            <figure>
                
                  <a href="{{ URL::to('/')}}" class="logo" data-toggle="tooltip" data-placement="bottom" title="@lang('website.logo')">
                    @if($result['commonContent']['settings']['sitename_logo']=='name')
                    <?=stripslashes($result['commonContent']['settings']['website_name'])?>
                    @endif
                
                    @if($result['commonContent']['settings']['sitename_logo']=='logo')
                    <img class="img-fluid" src="{{asset('').$result['commonContent']['settings']['website_logo']}}" alt="<?=stripslashes($result['commonContent']['settings']['website_name'])?>">
                    @endif
                  </a>
            </figure>
                <div class="footer-image mb-4">
                  <h5>@lang('website.DOWNLOAD OUR APP')</h5>
                  
                  <a href='https://play.google.com/store/apps/details?id=in.buildermart'><img alt='Get it on Google Play'  width="100%" class="img-fluid" src="{{ URL::asset('images/google_playstore.png')}}"/></a>
                  
               <!--    <a href="#"><img class="img-fluid" src="{{ URL::asset('web/images/miscellaneous/google-play-btn.png')}}" alt="google-btn"></a>
                  <a href="#"><img class="img-fluid" src="{{ URL::asset('web/images/miscellaneous/app-store-btn.png')}}" alt="appstore"></a> -->
                <div class="social-content">
                  <div class="social-div">
             <h5>Follow Us</h5>
              <div class="row align-items-left justify-content-between">
               
                
                        <ul class="social">

                            <li>
                              @if(!empty($result['commonContent']['setting'][50]->value))
                                  <a target="_blank" href="{{$result['commonContent']['setting'][50]->value}}" class="fab fa-facebook-f" data-toggle="tooltip" data-placement="bottom" title="@lang('website.facebook')"></a>
                              @else
                              <a  target="_blank"  href="{{$result['commonContent']['setting'][50]->value}}" class="fab fa-facebook-f" data-toggle="tooltip" data-placement="bottom" title="@lang('website.facebook')"></a>
                              @endif
                            </li> 
                            <li>
                              @if(!empty($result['commonContent']['setting'][52]->value))
                                  <a  target="_blank"  href="{{$result['commonContent']['setting'][52]->value}}"  class="fab fa-twitter" data-toggle="tooltip" data-placement="bottom" title="@lang('website.twitter')"></a>
                              @else
                                  <a  target="_blank"  href="#" class="fab fa-twitter" data-toggle="tooltip" data-placement="bottom" title="@lang('website.twitter')"></a>
                              @endif
                            </li>
            
                            <li>
                              @if(!empty($result['commonContent']['setting'][51]->value))
                                  <a   target="_blank"  href="{{$result['commonContent']['setting'][51]->value}}" class="fab sk fa-linkedin" data-toggle="tooltip" data-placement="bottom" title="Linkedin"></a>
                              @else
                              <a  target="_blank"  href="#"><i class="fab sk fa-linkedin"  data-toggle="tooltip" data-placement="bottom" title="Linkedin"></i></a>
                              @endif
                            </li>
            
                            <li>
                              @if(!empty($result['commonContent']['setting'][53]->value))
                                  <a  target="_blank"  href="{{$result['commonContent']['setting'][53]->value}}" class="fab fa-instagram" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Instagram')"></a>
                              @else
                                  <a  target="_blank"  href="#" class="fab fa-instagram" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Instagram')"></a>
                              @endif
                            </li>

                        </ul>
              
              </div>
          </div>
                </div>
                </div>
                
         
            </div>
          </div>
      </div>
      <div class="col-12 col-md-6 col-lg-10">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-3">
                <div class="single-footer single-footer-left">
                  <h5>@lang('website.Our Services')</h5>
                  <ul class="links-list pl-0 mb-0">
                    <li> <a href="{{ URL::to('/')}}"><i class="fa fa-angle-right"></i>@lang('website.Home')</a> </li>
                    <li> <a href="{{ URL::to('/shop')}}"><i class="fa fa-angle-right"></i>@lang('website.Shop')</a> </li>
                    <li> <a href="{{ URL::to('/orders')}}"><i class="fa fa-angle-right"></i>@lang('website.Orders')</a> </li>
                    <li> <a href="{{ URL::to('/viewcart')}}"><i class="fa fa-angle-right"></i>@lang('website.Shopping Cart')</a> </li>
                    <li> <a href="{{ URL::to('/wishlist')}}"><i class="fa fa-angle-right"></i>@lang('website.Wishlist')</a> </li>           
                  </ul>
                </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <h5>@lang('website.Information')</h5>
            <ul class="links-list pl-0 mb-0">
              @if(count($result['commonContent']['pages']))
                  @foreach($result['commonContent']['pages'] as $page)
                      <li> <a href="{{ URL::to('/page?name='.$page->slug)}}"><i class="fa fa-angle-right"></i>{{$page->name}}</a> </li>
                  @endforeach
              @endif
                  <li> <a href="{{ URL::to('/contact')}}"><i class="fa fa-angle-right"></i>@lang('website.Contact Us')</a> </li>
            </ul>
          </div>
          <div class="col-12 col-lg-3">
              <!--h5>@lang('website.Contact Us')</h5  -->
              <h5>Our Store</h5>
              <ul class="contact-list  pl-0 mb-0">
                <li> <i class="fas fa-map-marker"></i><span>
                      {{$result['commonContent']['setting'][49]->value}}  <br>
                     {{$result['commonContent']['setting'][4]->value}} 
                    {{$result['commonContent']['setting'][5]->value}}
                    {{$result['commonContent']['setting'][6]->value}},  <br>
                      {{$result['commonContent']['setting'][7]->value}}  
                      {{$result['commonContent']['setting'][8]->value}}</span> 
                     </li>
              <li> <i class="fas fa-phone"></i><span dir="ltr">Toll Free  {{$result['commonContent']['setting'][11]->value}}</span> </li>
              <li> <i class="fas fa-envelope"></i><span> <a href="mailto:{{$result['commonContent']['setting'][3]->value}}">{{$result['commonContent']['setting'][3]->value}}</a> </span> </li>
              </ul>
              
              
              
          </div>
          
          <div class="col-12 col-lg-3">
       
                <h5>Headquarters</h5>
              <ul class="contact-list  pl-0 mb-0">
                <li> 
                
                <i class="fas fa-map-marker"></i><span>
                                          {{$result['commonContent']['setting'][49]->value}}  <br>

                    {{$result['commonContent']['setting'][130]->value}}<br>
                     {{$result['commonContent']['setting'][132]->value}}<br>
                      {{$result['commonContent']['setting'][131]->value}}<br>
                    
                    </span> </li>
              <!--li> <i class="fas fa-phone"></i><span dir="ltr">{    {$result['commonContent']['setting'][11]->value}}</span> </li-->
              
              
              
              <li> <i class="fas fa-envelope"></i><span> <a href="mailto:{{$result['commonContent']['setting'][133]->value}}">{{$result['commonContent']['setting'][133]->value}}</a> </span> </li>
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
                
                <div class="col-12 col-md-12">
                      
                      <div class="footer-info">
                          © @lang('website.Copy Rights').  <a href="{{url('/page?name=refund-policy')}}">@lang('website.Privacy')</a>&nbsp;&bull;&nbsp;<a href="{{url('/page?name=term-services')}}">@lang('website.Terms')</a>
                      </div>
                </div>
                <!--div class="col-12 col-md-4">
                        <ul class="social">

                            <li>
                              @if(!empty($result['commonContent']['setting'][50]->value))
                                  <a href="{{$result['commonContent']['setting'][50]->value}}" class="fab fa-facebook-f" data-toggle="tooltip" data-placement="bottom" title="@lang('website.facebook')"></a>
                              @else
                              <a href="{{$result['commonContent']['setting'][50]->value}}" class="fab fa-facebook-f" data-toggle="tooltip" data-placement="bottom" title="@lang('website.facebook')"></a>
                              @endif
                            </li> 
                            <li>
                              @if(!empty($result['commonContent']['setting'][52]->value))
                                  <a href="{{$result['commonContent']['setting'][52]->value}}"  class="fab fa-twitter" data-toggle="tooltip" data-placement="bottom" title="@lang('website.twitter')"></a>
                              @else
                                  <a href="#" class="fab fa-twitter" data-toggle="tooltip" data-placement="bottom" title="@lang('website.twitter')"></a>
                              @endif
                            </li>
            
                            <li>
                              @if(!empty($result['commonContent']['setting'][51]->value))
                                  <a href="{{$result['commonContent']['setting'][51]->value}}" class="fab sk fa-google" data-toggle="tooltip" data-placement="bottom" title="@lang('website.google')"></a>
                              @else
                                  <a href="#"><i class="fab sk fa-google"  data-toggle="tooltip" data-placement="bottom" title="@lang('website.google')"></i></a>
                              @endif
                            </li>
            
                            <li>
                              @if(!empty($result['commonContent']['setting'][53]->value))
                                  <a href="{{$result['commonContent']['setting'][53]->value}}" class="fab fa-instagram" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Instagram')"></a>
                              @else
                                  <a href="#" class="fab fa-instagram" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Instagram')"></a>
                              @endif
                            </li>

                        </ul>
                </div  -->
              </div>
          </div>
          </div>  
      </div>
  </div>
</footer>

