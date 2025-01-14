  
    <header id="headerSix" class="header-area header-six header-desktop d-none d-lg-block d-xl-block">
    
     @include('web.headers.topcategories')
  
 </header>
 <section class="carousel-content">
  <div class="container-fuild">
    <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">

      @foreach($result['slides'] as $key=>$slides_data)
        <li data-target="#carouselExampleIndicators1" data-slide-to="{{ $key }}" class="@if($key==0) active @endif"></li>
      @endforeach

    </ol>
    <div class="carousel-inner">
      @foreach($result['slides'] as $key=>$slides_data)
          <div class="carousel-item  @if($key==0) active @endif">
          @if($slides_data->type == 'category')
            <a href="{{ URL::to('/shop?category='.$slides_data->url)}}">
          @elseif($slides_data->type == 'product')
            <a href="{{ URL::to('/product-detail/'.$slides_data->url)}}">
          @elseif($slides_data->type == 'mostliked')
            <a href="{{ URL::to('shop?type=mostliked')}}">
          @elseif($slides_data->type == 'topseller')
            <a href="{{ URL::to('shop?type=topseller')}}">
          @elseif($slides_data->type == 'deals')
            <a href="{{ URL::to('shop?type=deals')}}">
          @endif 
            <img class="d-block w-100"  src="{{asset('').$slides_data->path}}" width="100%" height="200" alt="First slide">
          </a>
          </div>
        @endforeach     
    </div>

    <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-slide="prev">
      <span class="sr-only"></span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-slide="next">
      <span class="sr-only"></span>
    </a>
  </div>
  </div>
</section>
