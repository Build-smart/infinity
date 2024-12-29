  
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>

<style>

.customer-logos{
	padding:10px;
	
    box-shadow: -3px 12px 24px -10px rgba(0,0,0,0.08) ,-3px -12px 24px -17px rgba(0,0,0,0.08);
 
}
 
 .text{
  text-align:center;
   padding:10px;
}
/* Slider */

.slick-slide {
    margin: 0px 0px;
	
	
}
.slick-slide img {
    width: 60%;
}

.slick-slider
{
    position: relative;
    display: block;
    box-sizing: border-box;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
            user-select: none;
    -webkit-touch-callout: none;
    -khtml-user-select: none;
    -ms-touch-action: pan-y;
        touch-action: pan-y;
    -webkit-tap-highlight-color: transparent;
	backgroud-color:#ccc;
 
}

.slick-list
{
    position: relative;
    display: block;
    overflow: hidden;
    margin: 0;
    padding: 0;
}
.slick-list:focus
{
    outline: none;
}
.slick-list.dragging
{
    cursor: pointer;
    cursor: hand;
}

.slick-slider .slick-track,
.slick-slider .slick-list
{
    -webkit-transform: translate3d(0, 0, 0);
       -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
         -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
}

.slick-track
{
    position: relative;
    top: 0;
    left: 0;
    display: block;
}
.slick-track:before,
.slick-track:after
{
    display: table;
    content: '';
}
.slick-track:after
{
    clear: both;
}
.slick-loading .slick-track
{
    visibility: hidden;
}

.slick-slide
{
    display: none;
    float: left;
    height: 60%;
    min-height: 1px;
}
[dir='rtl'] .slick-slide
{
    float: right;
}
.slick-slide img
{
    display: block;
}
.slick-slide.slick-loading img
{
    display: none;
}
.slick-slide.dragging img
{
    pointer-events: none;
}
.slick-initialized .slick-slide
{
    display: block;
}
.slick-loading .slick-slide
{
    visibility: hidden;
}
.slick-vertical .slick-slide
{
    display: block;
    height: auto;
    border: 1px solid transparent;
}
.slick-arrow.slick-hidden {
    display: none;
}

   
/*--------------------------------------------------------------
# Sections
--------------------------------------------------------------*/
section {
  overflow: hidden;
}

/* Sections Header
--------------------------------*/
.section-header h3 {
  font-size: 36px;
  color: #413e66;
  text-align: center;
  font-weight: 700;
  position: relative;
 
}
.section-header p {
  text-align: center;
  margin: auto;
  font-size: 15px;
  padding-bottom: 60px;
  color: #535074;
  width: 50%;
}
@media (max-width: 767px) {
  .section-header p {
    width: 100%;
  }
}


.min-margin{
    position: relative;
    width: 100%;
    padding-right: 1px;
    padding-left: 1px;
}


/* Section with background
--------------------------------*/
.section-bg {
  background: #e9e9e9;
}
 

/* Services Section
--------------------------------*/
#services {
  padding: 30px 0 30px 0;
}
#services .box {
  padding: 10px;
  position: relative;
  overflow: hidden;
  border-radius: 5px;
 margin: 5px 10px 5px 10px;


  background: #e7e7e7;
  box-shadow: 0 10px 29px 0 rgba(68, 88, 144, 0.1);
  transition: all 0.3s ease-in-out;
  text-align: center;
}
#services .box:hover {
  transform: scale(1.1);
  backgroud-color:#479AF1;
}
#services .icon {
  margin: 0 auto 15px auto;
  padding-top: 12px;
  display: inline-block;
  text-align: center;
  border-radius: 50%;
  width: 60px;
  height: 60px;
}
#services .icon i {
  font-size: 36px;
  line-height: 0;
}
#services .title {
  font-weight: 700;
  margin-bottom: 15px;
  font-size: 1rem;
}
#services .title a {
  color: #111;
}
#services .box:hover .title a {
  color: #1bb1dc;
}
#services .description {
  font-size: 12px;
  line-height: 24px;
  margin-bottom: 0;
  text-align: left;
}
 
.btn-text-center{

width: 100% !important;
text-align:center !important;
}
 
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}

.text-padding{

padding-top:20px;
padding-bottom:20px;

}

.bg-color{
background-color: #ffffff;

}

.m-bt{
margin: 0px 5px 0px 5px;
}

.m-bt2{
margin: 6px 5px 0px 5px;
 }
 
 .m-bt3{
margin: 0px 0px 5px px;
 }
 
.banner-width{
width:100%;
}
 
</style>

<div id="main">
<section id="services" class="services section-bgx">
      <div class="container aos-init aos-animate" data-aos="fade-up">

     

        <div class="row">

          <div class="col-6 col-md-6 col-lg-2 col-md-6 col-lg-3 wow bounceInUp aos-init aos-animate min-margin" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
               
 <h4 class="title">Building Materials Online</h4>

              <a href="{{url('/')}}"><p class="description btn btn-secondary btn-text-center"  >E-Commerce</p></a>
            </div>
          </div>
          
		  
		  
		  
		  
          <div class="col-6 col-md-6 col-lg-2 col-md-6 col-lg-3 wow bounceInUp aos-init aos-animate min-margin" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
               
             <h4 class="title">Build your Home Wisely</h4>


              <a href="{{url('constructions')}}"><p class="description btn btn-secondary btn-text-center">Constructions</p></a>
            </div>
          </div>
          
          
		  
		  
		       <?php if(auth()->guard('customer')->check()){ ?> 
          <div class="col-6 col-md-6 col-lg-2 col-md-6 col-lg-3 wow bounceInUp aos-init aos-animate min-margin" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
               
<h4 class="title">Home Construction</h4>


              <a href="{{url('cost_calculator')}}"><p class="description btn btn-secondary btn-text-center">Cost Calculator</p></a>
            </div>
          </div>
		      <?php }else{ ?>
                
              
		  <div class="col-6 col-md-6 col-lg-2 col-md-6 col-lg-3 wow bounceInUp aos-init aos-animate min-margin" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
               
<h4 class="title">Associated Partners</h4>

              <a href="{{url('login')}}"><p class="description btn btn-secondary btn-text-center">Login</p></a>
            </div>
          </div>
		     <?php } ?>
		      
          <div class="col-6 col-md-6 col-lg-2 col-md-6 col-lg-3 wow bounceInUp aos-init aos-animate min-margin" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
               
<h4 class="title">Our Products &amp; Materials</h4>

              <a href="{{ URL::to('/shop?category=bm-products')}}"><p class="description btn btn-secondary btn-text-center">BM Brand</p></a>
            </div>
          </div>
		  
		  
 

      </div>

      </div>
    </section>
	
	</div>

  
 
@if(!empty($result['commonContent']['manufacturers']) and count($result['commonContent']['manufacturers'])>0)
<div class="">
  <h2 class="text">Our Associated Brands</h2>
   <section class="customer-logos  slider">
   

    @foreach ($result['commonContent']['manufacturers'] as $item)
   
   <div class="slide"><img src="{{asset('').$item->manufacturer_image}}"></div>
   
   @endforeach
   
   </section>
   
 </div>
 @endif

@if(!empty($result['commonContent']['categories']))
<section class="categories-content pro-content  ">
    <div class=" ">
      <div class="products-area">
         <div class="row justify-content-center">
           <div class="col-12 col-lg-6">
             <div class="pro-heading-title">
               <h2> @lang('website.PRODUCT CATEGORIES')
               </h2>
               <p class="text-dark">
                 @lang('website.Categories Text For Home Page')
                </p>
               </div>
             </div>
         </div>
      
      </div>
      
       <?php $counter = 0;
    
    
  
    ?>
    @foreach($result['commonContent']['categories'] as $categories_data)
     
       <div class="row  section-bg"  > 
       <div class="col-12 bg-color m-bt2" >
   <h4 class="text-padding  ">{{strtoupper($categories_data->name)}}  </h4>
    
  </div>
    <section class="customer-logo  slider bg-color m-bt">
    @if(strtoupper($categories_data->name) == strtoupper('CIVIL SUPPLIES'))

                   @foreach($categories_data->sub_categories as $specialcategories_data)
       
   
    <div class="slide">
      <a href="{{ URL::to('/shop?category='.$specialcategories_data->sub_slug)}}"> 
      <img class="  center"    src="{{asset('').$specialcategories_data->path}}"> 
    <div class="text text-dark">
                  <strong >{{$specialcategories_data->sub_name}}</strong>
               </div> </a>
               
    </div>
    
    
    
    @endforeach
    </section>
    
    <section class="carousel-content banner-width">
  <div class="container-fuild">
    <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
    
    <div class="carousel-inner">
      @foreach($result['commonContent']['promotional_banners'] as $key=>$promotional_banner)
       @if(strtoupper($promotional_banner->categories_name) == strtoupper('CIVIL SUPPLIES'))
            <img class="d-block   m-bt "   src="{{asset('').$promotional_banner->path}}" width="99.2%" height="200" alt="First slide">
         
           @endif
        @endforeach     
    </div>

 
  </div>
  </div>
</section>
	    <section class="customer-logo  slider bg-color m-bt">
    @elseif(strtoupper($categories_data->name) == strtoupper('ELECTRICALS'))
    @foreach($categories_data->sub_categories as $specialcategories_data)
       
   
    <div class="slide">
      <a href="{{ URL::to('/shop?category='.$specialcategories_data->sub_slug)}}"> 
      <img class=" center"     src="{{asset('').$specialcategories_data->path}}"> 
    <div class="text text-dark">
                  <strong >{{$specialcategories_data->sub_name}}</strong>
               </div> </a>
               
    </div>
    @endforeach
     </section>
     <section class="carousel-content banner-width">
  <div class="container-fuild">
    <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
    
    <div class="carousel-inner">
      @foreach($result['commonContent']['promotional_banners'] as $key=>$promotional_banner)
       @if(strtoupper($promotional_banner->categories_name) == strtoupper("ELECTRICALS"))
            <img class="d-block m-bt "   src="{{asset('').$promotional_banner->path}}" width="99.2%" height="200" alt="First slide">
         
           @endif
        @endforeach     
    </div>

 
  </div>
  </div>
</section>
     
     <section class="customer-logo  slider bg-color m-bt">
     
    @elseif(strtoupper($categories_data->name) == strtoupper('PLUMBING'))
       @foreach($categories_data->sub_categories as $specialcategories_data)
       
   
    <div class="slide">
      <a href="{{ URL::to('/shop?category='.$specialcategories_data->sub_slug)}}"> 
      <img class=" center"    src="{{asset('').$specialcategories_data->path}}"> 
    <div class="text text-dark">
                  <strong >{{$specialcategories_data->sub_name}}</strong>
               </div> </a>
               
    </div>
  
    @endforeach
      </section>
     <section class="customer-logo  slider bg-color m-bt">
  
              @elseif(strtoupper($categories_data->name) == strtoupper('SANITARY'))
    @foreach($categories_data->sub_categories as $specialcategories_data)
       
   
    <div class="slide">
      <a href="{{ URL::to('/shop?category='.$specialcategories_data->sub_slug)}}"> 
      <img class=" center"    src="{{asset('').$specialcategories_data->path}}"> 
    <div class="text text-dark">
                  <strong >{{$specialcategories_data->sub_name}}</strong>
               </div> </a>
               
    </div>
     @endforeach
     </section>
     <section class="carousel-content banner-width">
  <div class="container-fuild">
    <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
    
    <div class="carousel-inner">
      @foreach($result['commonContent']['promotional_banners'] as $key=>$promotional_banner)
       @if(strtoupper($promotional_banner->categories_name) == strtoupper("SANITARY"))
            <img class="d-block m-bt"   src="{{asset('').$promotional_banner->path}}" width="99.2%" height="200" alt="First slide">
         
           @endif
        @endforeach     
    </div>

 
  </div>
  </div>
</section>
      <section class="customer-logo  slider bg-color m-bt">
  
      @elseif(strtoupper($categories_data->name) == strtoupper('PAINTS & FINISHES'))
    @foreach($categories_data->sub_categories as $specialcategories_data)
       
   
    <div class="slide">
      <a href="{{ URL::to('/shop?category='.$specialcategories_data->sub_slug)}}"> 
      <img class="  center"     src="{{asset('').$specialcategories_data->path}}"> 
    <div class="text text-dark">
                  <strong >{{$specialcategories_data->sub_name}}</strong>
               </div> </a>
               
    </div>
     @endforeach
     </section>
      
      <section class="customer-logo  slider bg-color m-bt">
  
      @elseif(strtoupper($categories_data->name) == strtoupper('HARDWARE & GLASS'))
           @foreach($categories_data->sub_categories as $specialcategories_data)
       
   
    <div class="slide" >
      <a href="{{ URL::to('/shop?category='.$specialcategories_data->sub_slug)}}"> 
      <img class="  center"     src="{{asset('').$specialcategories_data->path}}"> 
    <div class="text text-dark">
                  <strong >{{$specialcategories_data->sub_name}}</strong>
               </div> </a>
               
    </div>
     @endforeach
     </section>
    <section class="carousel-content banner-width ">
  <div class="container-fuild">
    <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
    
    <div class="carousel-inner">
      @foreach($result['commonContent']['promotional_banners'] as $key=>$promotional_banner)
       @if(strtoupper($promotional_banner->categories_name) == strtoupper("HARDWARE & GLASS"))
            <img class="d-block m-bt"   src="{{asset('').$promotional_banner->path}}" width="99.2%" height="200" alt="First slide">
         
           @endif
        @endforeach     
    </div>

 
  </div>
  </div>
</section>
     @endif   
    
     
                
     </div>
    
   
   
	  
      <?php $counter++;?>
    @endforeach
   </div>
  </section>
  @endif
<div class="container">
	<div class="row">
		<div class="col-12 col-lg-12">

			<h4>Brand Directories:</h4>
	
<?php

 
$subcategories = $result['commonContent']['brandcategory'];

$categories =array_unique( Arr::pluck ($subcategories, 'name' ));
 
?>
	   @foreach($categories as $categoryName)
   
   <strong>  <span class="badge badge-dark">{{$categoryName}} </span> </strong> @foreach($result['commonContent']['brandcategory'] as $brandcat)
  
    @if($categoryName==$brandcat->name)
	 	 
	<span class="badge  ">{{$brandcat->manufacturer_name}}, </span>

	 @endif 
			 
			
	 @endforeach
		<br>	
			
	  @endforeach
	 	
 
		</div>
	</div>
	
	 
</div>



  
  <script type="text/javascript">
  $(document).ready(function(){
	  
	  $('#myCarousel').carousel({
  interval: 1000
}) 
	  
	    $('.customer-logos').slick({
	        slidesToShow: 6,
	        slidesToScroll: 1,
	        autoplay: true,
	        autoplaySpeed: 2000,
	        arrows: false,
	        dots: false,
	        pauseOnHover: false,
	        responsive: [{
	            breakpoint: 768,
	            settings: {
	                slidesToShow: 4
	            }
	        }, {
	            breakpoint: 520,
	            settings: {
	                slidesToShow: 3
	            }
	        }]
	    });


	  $('.customer-logo').slick({
	        slidesToShow: 6,
	        slidesToScroll: 1,
	        autoplay: true,
	        autoplaySpeed: 3000,
	        arrows: false,
	        dots: false,
	        pauseOnHover: false,
	        responsive: [{
	            breakpoint: 768,
	            settings: {
	                slidesToShow: 4
	            }
	        }, {
	            breakpoint: 520,
	            settings: {
	                slidesToShow: 3
	            }
	        }]
	    });


	    
	});
</script>