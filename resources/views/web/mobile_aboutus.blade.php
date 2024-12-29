

   <style>
   
#call-to-action {
  background: #393a3c;
  background-size: cover;
  padding: 40px 0;
}
#call-to-action .cta-title {
  color: #fff;
  font-size: 28px;
  font-weight: 700;
}
#call-to-action .cta-text {
  color: #fff;
}
@media (min-width: 769px) {
  #call-to-action .cta-btn-container {
    display: flex;
    align-items: center;
    justify-content: flex-end;
  }
}
#call-to-action .cta-btn {
  font-family: "Montserrat", sans-serif;
  font-weight: 700;
  font-size: 16px;
  letter-spacing: 1px;
  display: inline-block;
  padding: 8px 26px;
  border-radius: 3px;
  transition: 0.5s;
  margin: 10px;
  border: 3px solid #fff;
  color: #fff;
}
#call-to-action .cta-btn:hover {
  background: #50d8af;
  border: 3px solid #50d8af;
}
.back-to-top {
  position: fixed;
  visibility: hidden;
  opacity: 0;
  right: 15px;
  bottom: 15px;
  z-index: 996;
  background: #ff5821;
  width: 40px;
  height: 40px;
  border-radius: 4px;
  transition: all 0.4s;
}
.back-to-top i {
  font-size: 28px;
  color: #fff;
  line-height: 0;
}
.back-to-top:hover {
  background: #ff774a;
  color: #fff;
}
.back-to-top.active {
  visibility: visible;
  opacity: 1;
}

/*--------------------------------------------------------------
# Disable aos animation delay on mobile devices
--------------------------------------------------------------*/
@media screen and (max-width: 768px) {
  [data-aos-delay] {
    transition-delay: 0 !important;
  }
}
/*--------------------------------------------------------------
# Top Bar
--------------------------------------------------------------*/
#topbar {
  background: #39312f;
  font-size: 14px;
  padding: 0;
  color: rgba(255, 255, 255, 0.8);
  height: 40px;
}
#topbar .contact-info i {
  font-style: normal;
  color: #ff5821;
}
#topbar .contact-info i a, #topbar .contact-info i span {
  padding-left: 5px;
  color: #fff;
}
#topbar .contact-info i a {
  line-height: 0;
  transition: 0.3s;
}
#topbar .contact-info i a:hover {
  color: #ff5821;
}
#topbar .cta a {
  color: #fff;
  background: #ff5821;
  padding: 10px 20px;
  display: inline-block;
  transition: 0.3s;
}
#topbar .cta a:hover {
  background: #ff6b3b;
}

/*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/
#header {
  height: 70px;
  transition: all 0.5s;
  z-index: 997;
  background: #fff;
}
#header.header-fixed {
  box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
}
#header .logo h1 {
  font-size: 28px;
  margin: 0;
  line-height: 0;
  font-weight: 700;
  font-family: "Montserrat-Regular", sans-serif;
}
#header .logo h1 a, #header .logo h1 a:hover {
  color: #635551;
  text-decoration: none;
}
#header .logo img {
  padding: 0;
  margin: 0;
  max-height: 40px;
}

.scrolled-offset {
  margin-top: 70px;
}

#main {
  z-index: 3;
}
  
/*--------------------------------------------------------------
# Hero Section
--------------------------------------------------------------*/
#hero {
  width: 100%;
  height: 60vh;
  position: relative;
  background: url("../img/hero-carousel/1.jpg") no-repeat;
  background-size: cover;
  padding: 0;
}
#hero .hero-content {
  position: absolute;
  bottom: 0;
  top: 0;
  left: 0;
  right: 0;
  z-index: 10;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  text-align: center;
}
#hero .hero-content h2 {
  color: #ffffff;
  margin-bottom: 10px;
  font-size: 64px;
  font-weight: 700;
}
#hero .hero-content h2 span {
  color: #ffd400;
  background-color:#393a3cb8;
  padding:10px;
  /*text-decoration: underline;*/
}
@media (max-width: 767px) {
  #hero .hero-content h2 {
    font-size: 34px;
  }
}
#hero .hero-content .btn-get-started, #hero .hero-content .btn-projects {
  font-family: "Montserrat-Regular", sans-serif;
  font-size: 15px;
  font-weight: bold;
  letter-spacing: 1px;
  display: inline-block;
  padding: 10px 32px;
  border-radius: 2px;
  transition: 0.5s;
  margin: 10px;
  color: #fff;
}
#hero .hero-content .btn-get-started {
  background: #0c2e8a;
  border: 2px solid #0c2e8a;
}
#hero .hero-content .btn-get-started:hover {
  background: none;
  color: #0c2e8a;
}
#hero .hero-content .btn-projects {
  background: #50d8af;
  border: 2px solid #50d8af;
}
#hero .hero-content .btn-projects:hover {
  background: none;
  color: #50d8af;
}
#hero .hero-slider {
  z-index: 8;
  height: 60vh;
}
#hero .hero-slider::before {
  content: "";
  background-color: rgba(255, 255, 255, 0.7);
  position: absolute;
  height: 100%;
  width: 100%;
  top: 0;
  right: 0;
  left: 0;
  bottom: 0;
  z-index: 7;
}
#hero .hero-slider .swiper-slide {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  transition-property: opacity;
}


/*--------------------------------------------------------------
# Sections General
--------------------------------------------------------------*/
section {
  padding: 60px 0;
  overflow: hidden;
}

.section-bg {
  background-color: #fff9f7;
}

.section-title {
  text-align: center;
  padding-bottom: 20px;
}
.section-title h2 {
  font-size: 32px;
  font-weight: 500;
  margin-bottom: 20px;
  padding-bottom: 0;
  font-family:"Montserrat-Regular", sans-serif;
  color: #000;
}
.section-title p {
  margin-bottom: 0;
}

/*--------------------------------------------------------------
# Breadcrumbs
--------------------------------------------------------------*/
.breadcrumbs {
  padding: 15px 0;
  background: #f4f2f2;
  margin-bottom: 40px;
}
.breadcrumbs h2 {
  font-size: 28px;
  font-weight: 500;
}
.breadcrumbs ol {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  padding: 0 0 10px 0;
  margin: 0;
  font-size: 14px;
}
.breadcrumbs ol li + li {
  padding-left: 10px;
}
.breadcrumbs ol li + li::before {
  display: inline-block;
  padding-right: 10px;
  color: #635551;
  content: "/";
}

/*--------------------------------------------------------------
# Why Us
--------------------------------------------------------------*/
.why-us {
  padding: 0 0 30px 0;
  position: relative;
  z-index: 3;
}
.why-us .content {
  padding: 30px;
  background: #393a3c;
  border-radius: 4px;
  color: #fff;
}
.why-us .content h3 {
  font-weight: 700;
  font-size: 34px;
  margin-bottom: 30px;
}
.why-us .content p {
  margin-bottom: 30px;
  color:#fff;
}
.why-us .content .more-btn {
  display: inline-block;
  background: rgba(255, 255, 255, 0.2);
  padding: 6px 30px 8px 30px;
  color: #fff;
  border-radius: 50px;
  transition: all ease-in-out 0.4s;
}
.why-us .content .more-btn i {
  font-size: 14px;
}
.why-us .content .more-btn:hover {
  color: #ff5821;
  background: #fff;
}
.why-us .icon-boxes .icon-box {
  text-align: center;
  border-radius: 10px;
  background: #fff;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
  padding: 40px 30px;
  width: 100%;
}
.why-us .icon-boxes .icon-box i {
  font-size: 40px;
  color: #ff5821;
  margin-bottom: 30px;
}
.why-us .icon-boxes .icon-box h4 {
  font-size: 20px;
  font-weight: 700;
  margin: 0 0 30px 0;
}
.why-us .icon-boxes .icon-box p {
  font-size: 15px;
  color: #716f6f;
  text-align: justify;
}

/*--------------------------------------------------------------
# About
--------------------------------------------------------------*/
.about .icon-boxes h4 {
  font-size: 18px;
  color: #7f6d68;
  margin-bottom: 15px;
}
.about .icon-boxes h3 {
  font-size: 28px;
  font-weight: 700;
  color: #554945;
  margin-bottom: 15px;
}
.about .icon-box {
  margin-top: 20px;
  backgroud:#ebebebd1;
}
.about .icon-box .icon {
  float: left;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 64px;
  height: 64px;
  border: 2px solid #ffcbba;
  border-radius: 50px;
  transition: 0.5s;
  background: #fff;
}
.about .icon-box .icon i {
  color: #ff5821;
  font-size: 32px;
}
.about .icon-box:hover .icon {
  background: #ff5821;
  border-color: #ff5821;
}
.about .icon-box:hover .icon i {
  color: #fff;
}
.about .icon-box .title {
  margin-left: 85px;
  font-weight: 700;
  margin-bottom: 10px;
  font-size: 18px;
}
.about .icon-box .title a {
  color: #343a40;
  transition: 0.3s;
}
.about .icon-box .title a:hover {
  color: #ff5821;
}
.about .icon-box .description {
  margin-left: 85px;
  line-height: 24px;
  font-size: 14px;
}
.about .video-box {
  background: url({{asset('images/construction/about.jpg')}}) center center no-repeat;
  background-size: cover;
  min-height: 500px;
}
.about .play-btn {
  width: 94px;
  height: 94px;
  background: radial-gradient(#ff5821 50%, rgba(255, 88, 33, 0.4) 52%);
  border-radius: 50%;
  display: block;
  position: absolute;
  left: calc(50% - 47px);
  top: calc(50% - 47px);
  overflow: hidden;
}
.about .play-btn::after {
  content: "";
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translateX(-40%) translateY(-50%);
  width: 0;
  height: 0;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
  border-left: 15px solid #fff;
  z-index: 100;
  transition: all 400ms cubic-bezier(0.55, 0.055, 0.675, 0.19);
}
.about .play-btn::before {
  content: "";
  position: absolute;
  width: 120px;
  height: 120px;
  -webkit-animation-delay: 0s;
  animation-delay: 0s;
  -webkit-animation: pulsate-btn 2s;
  animation: pulsate-btn 2s;
  -webkit-animation-direction: forwards;
  animation-direction: forwards;
  -webkit-animation-iteration-count: infinite;
  animation-iteration-count: infinite;
  -webkit-animation-timing-function: steps;
  animation-timing-function: steps;
  opacity: 1;
  border-radius: 50%;
  border: 5px solid rgba(255, 88, 33, 0.7);
  top: -15%;
  left: -15%;
  background: rgba(198, 16, 0, 0);
}
.about .play-btn:hover::after {
  border-left: 15px solid #ff5821;
  transform: scale(20);
}
.about .play-btn:hover::before {
  content: "";
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translateX(-40%) translateY(-50%);
  width: 0;
  height: 0;
  border: none;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
  border-left: 15px solid #fff;
  z-index: 200;
  -webkit-animation: none;
  animation: none;
  border-radius: 0;
}

@-webkit-keyframes pulsate-btn {
  0% {
    transform: scale(0.6, 0.6);
    opacity: 1;
  }
  100% {
    transform: scale(1, 1);
    opacity: 0;
  }
}

@keyframes pulsate-btn {
  0% {
    transform: scale(0.6, 0.6);
    opacity: 1;
  }
  100% {
    transform: scale(1, 1);
    opacity: 0;
  }
}
/*--------------------------------------------------------------
# Clients
--------------------------------------------------------------*/
.clients .swiper-pagination {
  margin-top: 20px;
  position: relative;
}
.clients .swiper-pagination .swiper-pagination-bullet {
  width: 12px;
  height: 12px;
  background-color: #fff;
  opacity: 1;
  border: 1px solid #ff5821;
}
.clients .swiper-pagination .swiper-pagination-bullet-active {
  background-color: #ff5821;
}
.clients .swiper-slide img {
  opacity: 0.5;
  filter: grayscale(100%);
}
.clients .swiper-slide img:hover {
  filter: none;
  opacity: 1;
}

/*--------------------------------------------------------------
# Services
--------------------------------------------------------------*/
.services .icon-box {
  padding: 50px 20px;
  margin-top: 35px;
  margin-bottom: 25px;
  text-align: center;
  height: 200px;
  position: relative;
  background: #fff;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
}
.services .icon {
  position: absolute;
  top: -36px;
  left: calc(50% - 36px);
  transition: 0.2s;
  border-radius: 50%;
  border: 6px solid #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  text-align: center;
  width: 72px;
  height: 72px;
  background: #ff5821;
}
.services .icon i {
  color: #fff;
  font-size: 24px;
  line-height: 0;
}
.services .title {
  font-weight: 700;
  margin-bottom: 15px;
  font-size: 18px;
  text-transform: uppercase;
}
.services .title a {
  color: #343a40;
}
.services .icon-box:hover .icon {
  background: #fff;
  border: 2px solid #ff5821;
}
.services .icon-box:hover .icon i {
  color: #ff5821;
}
.services .icon-box:hover .title a {
  color: #ff5821;
}
.services .description {
  line-height: 24px;
  font-size: 14px;
}

/*--------------------------------------------------------------
# Values
--------------------------------------------------------------*/
.values .card {
  border: 0;
  padding: 160px 20px 20px 20px;
  position: relative;
  width: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
}
.values .card-body {
  z-index: 10;
  background: rgba(255, 255, 255, 0.9);
  padding: 15px 30px;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
  transition: 0.3s;
  transition: ease-in-out 0.4s;
  border-radius: 5px;
}
.values .card-title {
  font-weight: 700;
  text-align: center;
  margin-bottom: 15px;
}
.values .card-title a {
  color: #473d3a;
}
.values .card-text {
  color: #4b4949;
}
.values .read-more a {
  color: #656262;
  text-transform: uppercase;
  font-weight: 600;
  font-size: 12px;
  transition: 0.4s;
}
.values .read-more a:hover {
  text-decoration: underline;
}
.values .card:hover .card-body {
  background: #ff5821;
}
.values .card:hover .read-more a, .values .card:hover .card-title, .values .card:hover .card-title a, .values .card:hover .card-text {
  color: #fff;
}

/*--------------------------------------------------------------
# Testimonials
--------------------------------------------------------------*/
.testimonials {
  padding: 20px 0;
  background: url({{asset('images/construction/testimonial-1.jpg')}}) no-repeat;
  background-position: center center;
  background-size: cover;
  position: relative;
}
.testimonials::before {
  content: "";
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
}
.testimonials .section-header {
  margin-bottom: 20px;
}
.testimonials .testimonials-carousel, .testimonials .testimonials-slider {
  overflow: hidden;
}
.testimonials .testimonial-item {
  text-align: center;
  color: #fff;
}
.testimonials .testimonial-item .testimonial-img {
  width: 100px;
  border-radius: 50%;
  border: 6px solid rgba(255, 255, 255, 0.15);
  margin: 0 auto;
}
.testimonials .testimonial-item h3 {
  font-size: 20px;
  font-weight: bold;
  margin: 10px 0 5px 0;
  color: #fff;
}
.testimonials .testimonial-item h4 {
  font-size: 14px;
  color: #ddd;
  margin: 0 0 15px 0;
}
.testimonials .testimonial-item .quote-icon-left, .testimonials .testimonial-item .quote-icon-right {
  color: rgba(255, 255, 255, 0.4);
  font-size: 26px;
}
.testimonials .testimonial-item .quote-icon-left {
  display: inline-block;
  left: -5px;
  position: relative;
}
.testimonials .testimonial-item .quote-icon-right {
  display: inline-block;
  right: -5px;
  position: relative;
  top: 10px;
}
.testimonials .testimonial-item p {
  font-style: italic;
  margin: 0 auto 15px auto;
  color: #eee;
}
.testimonials .swiper-pagination {
  margin-top: 20px;
  position: relative;
}
.testimonials .swiper-pagination .swiper-pagination-bullet {
  width: 12px;
  height: 12px;
  background-color: rgba(255, 255, 255, 0.5);
  opacity: 1;
}
.testimonials .swiper-pagination .swiper-pagination-bullet-active {
  background-color: #ff5821;
}
@media (min-width: 992px) {
  .testimonials .testimonial-item p {
    width: 80%;
  }
}

/*--------------------------------------------------------------
# Portfolio
--------------------------------------------------------------*/
.portfolio #portfolio-flters {
  padding: 0;
  margin: 0 auto 35px auto;
  list-style: none;
  text-align: center;
  border-radius: 50px;
  padding: 2px 15px;
}
.portfolio #portfolio-flters li {
  cursor: pointer;
  display: inline-block;
  padding: 10px 20px 12px 20px;
  font-size: 14px;
  font-weight: 600;
  line-height: 1;
  text-transform: uppercase;
  color: #313030;
  margin-bottom: 5px;
  transition: all 0.3s ease-in-out;
  border-radius: 50px;
}
.portfolio #portfolio-flters li:hover, .portfolio #portfolio-flters li.filter-active {
  color: #ff5821;
  background: #fff1ed;
}
.portfolio #portfolio-flters li:last-child {
  margin-right: 0;
}
.portfolio .portfolio-item {
  margin-bottom: 30px;
}
.portfolio .portfolio-item .portfolio-info {
  opacity: 0;
  position: absolute;
  left: 30px;
  right: 30px;
  bottom: 0;
  z-index: 3;
  transition: all ease-in-out 0.3s;
  background: rgba(255, 255, 255, 0.9);
  padding: 15px;
}
.portfolio .portfolio-item .portfolio-info h4 {
  font-size: 18px;
  color: #fff;
  font-weight: 600;
  color: #473d3a;
}
.portfolio .portfolio-item .portfolio-info p {
  color: #7f6d68;
  font-size: 14px;
  margin-bottom: 0;
}
.portfolio .portfolio-item .portfolio-info .preview-link, .portfolio .portfolio-item .portfolio-info .details-link {
  position: absolute;
  right: 40px;
  font-size: 24px;
  top: calc(50% - 18px);
  color: #635551;
}
.portfolio .portfolio-item .portfolio-info .preview-link:hover, .portfolio .portfolio-item .portfolio-info .details-link:hover {
  color: #ff5821;
}
.portfolio .portfolio-item .portfolio-info .details-link {
  right: 10px;
}
.portfolio .portfolio-item .portfolio-links {
  opacity: 0;
  left: 0;
  right: 0;
  text-align: center;
  z-index: 3;
  position: absolute;
  transition: all ease-in-out 0.3s;
}
.portfolio .portfolio-item .portfolio-links a {
  color: #fff;
  margin: 0 2px;
  font-size: 28px;
  display: inline-block;
  transition: 0.3s;
}
.portfolio .portfolio-item .portfolio-links a:hover {
  color: #ffa587;
}
.portfolio .portfolio-item:hover .portfolio-info {
  opacity: 1;
  bottom: 20px;
}

/*--------------------------------------------------------------
# Portfolio Details
--------------------------------------------------------------*/
.portfolio-details {
  padding-top: 20px;
}
.portfolio-details .portfolio-details-slider img {
  width: 100%;
}
.portfolio-details .portfolio-details-slider .swiper-pagination {
  margin-top: 20px;
  position: relative;
}
.portfolio-details .portfolio-details-slider .swiper-pagination .swiper-pagination-bullet {
  width: 12px;
  height: 12px;
  background-color: #fff;
  opacity: 1;
  border: 1px solid #ff5821;
}
.portfolio-details .portfolio-details-slider .swiper-pagination .swiper-pagination-bullet-active {
  background-color: #ff5821;
}
.portfolio-details .portfolio-info {
  padding: 30px;
  box-shadow: 0px 0 30px rgba(71, 61, 58, 0.08);
}
.portfolio-details .portfolio-info h3 {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 20px;
  padding-bottom: 20px;
  border-bottom: 1px solid #eee;
}
.portfolio-details .portfolio-info ul {
  list-style: none;
  padding: 0;
  font-size: 15px;
}
.portfolio-details .portfolio-info ul li + li {
  margin-top: 10px;
}
.portfolio-details .portfolio-description {
  padding-top: 30px;
}
.portfolio-details .portfolio-description h2 {
  font-size: 26px;
  font-weight: 700;
  margin-bottom: 20px;
}
.portfolio-details .portfolio-description p {
  padding: 0;
}

/*--------------------------------------------------------------
# Team
--------------------------------------------------------------*/
.team .member {
  margin-bottom: 20px;
  overflow: hidden;
  text-align: center;
  border-radius: 5px;
  background: #fff;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
}
.team .member .member-img {
  position: relative;
  overflow: hidden;
}
.team .member .social {
  position: absolute;
  left: 0;
  bottom: 0;
  right: 0;
  height: 40px;
  opacity: 0;
  transition: ease-in-out 0.3s;
  background: rgba(255, 255, 255, 0.85);
  display: flex;
  align-items: center;
  justify-content: center;
}
.team .member .social a {
  transition: color 0.3s;
  color: #473d3a;
  margin: 0 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.team .member .social a:hover {
  color: #ff5821;
}
.team .member .social i {
  font-size: 18px;
  line-height: 0;
}
.team .member .member-info {
  padding: 25px 15px;
}
.team .member .member-info h4 {
  font-weight: 700;
  margin-bottom: 5px;
  font-size: 18px;
  color: #473d3a;
}
.team .member .member-info span {
  display: block;
  font-size: 13px;
  font-weight: 400;
  color: #989595;
}
.team .member .member-info p {
  font-style: italic;
  font-size: 14px;
  line-height: 26px;
  color: #656262;
}
.team .member:hover .social {
  opacity: 1;
}

/*--------------------------------------------------------------
# Pricing
--------------------------------------------------------------*/
.pricing .box {
  padding: 20px;
  background: #fff;
  text-align: center;
  box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.12);
  border-radius: 5px;
  position: relative;
  overflow: hidden;
}
.pricing h3 {
  font-weight: 400;
  margin: -20px -20px 20px -20px;
  padding: 20px 15px;
  font-size: 16px;
  font-weight: 600;
  color: #656262;
  background: #f8f8f8;
}
.pricing h4 {
  font-size: 36px;
  color: #ff5821;
  font-weight: 600;
  font-family: "Montserrat-Regular", sans-serif;
  margin-bottom: 20px;
}
.pricing h4 sup {
  font-size: 20px;
  top: -15px;
  left: -3px;
}
.pricing h4 span {
  color: #bababa;
  font-size: 16px;
  font-weight: 300;
}
.pricing ul {
  padding: 0;
  list-style: none;
  color: #313030;
  text-align: center;
  line-height: 20px;
  font-size: 14px;
}
.pricing ul li {
  padding-bottom: 16px;
}
.pricing ul i {
  color: #ff5821;
  font-size: 18px;
  padding-right: 4px;
}
.pricing ul .na {
  color: #ccc;
  text-decoration: line-through;
}
.pricing .btn-wrap {
  margin: 20px -20px -20px -20px;
  padding: 20px 15px;
  background: #f8f8f8;
  text-align: center;
}
.pricing .btn-buy {
  background: #ff5821;
  display: inline-block;
  padding: 6px 35px 8px 35px;
  border-radius: 4px;
  color: #fff;
  transition: none;
  font-size: 14px;
  font-weight: 400;
  font-family: "Montserrat-Regular", sans-serif;
  font-weight: 600;
  box-shadow: 0 3px 7px rgba(255, 88, 33, 0.4);
  transition: 0.3s;
}
.pricing .btn-buy:hover {
  background: #ff7e54;
}
.pricing .featured h3 {
  color: #fff;
  background: #ff5821;
  box-shadow: 0 3px 7px rgba(255, 88, 33, 0.4);
}
.pricing .advanced {
  width: 200px;
  position: absolute;
  top: 18px;
  right: -68px;
  transform: rotate(45deg);
  z-index: 1;
  font-size: 14px;
  padding: 1px 0 3px 0;
  background: #ff5821;
  color: #fff;
}

/*--------------------------------------------------------------
# F.A.Q
--------------------------------------------------------------*/
.faq .faq-list {
  padding: 0 100px;
}
.faq .faq-list ul {
  padding: 0;
  list-style: none;
}
.faq .faq-list li + li {
  margin-top: 15px;
}
.faq .faq-list li {
  padding: 20px;
  background: #fff;
  border-radius: 4px;
  position: relative;
}
.faq .faq-list a {
  display: block;
  position: relative;
  font-family: "Montserrat-Regular", sans-serif;
  font-size: 16px;
  line-height: 24px;
  font-weight: 500;
  padding: 0 30px;
  outline: none;
  cursor: pointer;
}
.faq .faq-list .icon-help {
  font-size: 24px;
  position: absolute;
  right: 0;
  left: 20px;
  color: #ffb8a1;
}
.faq .faq-list .icon-show, .faq .faq-list .icon-close {
  font-size: 24px;
  position: absolute;
  right: 0;
  top: 0;
}
.faq .faq-list p {
  margin-bottom: 0;
  padding: 10px 0 0 0;
}
.faq .faq-list .icon-show {
  display: none;
}
.faq .faq-list a.collapsed {
  color: #343a40;
}
.faq .faq-list a.collapsed:hover {
  color: #ff5821;
}
.faq .faq-list a.collapsed .icon-show {
  display: inline-block;
}
.faq .faq-list a.collapsed .icon-close {
  display: none;
}
@media (max-width: 1200px) {
  .faq .faq-list {
    padding: 0;
  }
}

/*--------------------------------------------------------------
# Contact
--------------------------------------------------------------*/
.contact .info-box {
  color: #313030;
  box-shadow: 0 0 30px rgba(214, 215, 216, 0.6);
  padding: 20px;
}
.contact .info-box i {
  font-size: 32px;
  color: #ff5821;
  border-radius: 50%;
  padding: 8px;
  border: 2px dotted #ffded4;
  float: left;
}
.contact .info-box h3 {
  font-size: 20px;
  color: #656262;
  font-weight: 700;
  margin: 10px 0 10px 68px;
}
.contact .info-box p {
  padding: 0;
  line-height: 24px;
  font-size: 14px;
  margin: 0 0 0 68px;
}
.contact .php-email-form {
  box-shadow: 0 0 30px rgba(214, 215, 216, 0.6);
  padding: 30px;
}
.contact .php-email-form .error-message {
  display: none;
  color: #fff;
  background: #ed3c0d;
  text-align: left;
  padding: 15px;
  font-weight: 600;
}
.contact .php-email-form .error-message br + br {
  margin-top: 25px;
}
.contact .php-email-form .sent-message {
  display: none;
  color: #fff;
  background: #18d26e;
  text-align: center;
  padding: 15px;
  font-weight: 600;
}
.contact .php-email-form .loading {
  display: none;
  background: #fff;
  text-align: center;
  padding: 15px;
}
.contact .php-email-form .loading:before {
  content: "";
  display: inline-block;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  margin: 0 10px -6px 0;
  border: 3px solid #18d26e;
  border-top-color: #eee;
  -webkit-animation: animate-loading 1s linear infinite;
  animation: animate-loading 1s linear infinite;
}
.contact .php-email-form input, .contact .php-email-form textarea {
  border-radius: 0;
  box-shadow: none;
  font-size: 14px;
}
.contact .php-email-form input:focus, .contact .php-email-form textarea:focus {
  border-color: #ff5821;
}
.contact .php-email-form input {
  padding: 10px 15px;
}
.contact .php-email-form textarea {
  padding: 12px 15px;
}
.contact .php-email-form button[type=submit] {
  background: #ff5821;
  border: 0;
  padding: 10px 24px;
  color: #fff;
  transition: 0.4s;
}
.contact .php-email-form button[type=submit]:hover {
  background: #ff7e54;
}
@-webkit-keyframes animate-loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes animate-loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/*--------------------------------------------------------------
# Blog
--------------------------------------------------------------*/
.blog {
  padding: 20px 0;
}
.blog .entry {
  padding: 30px;
  margin-bottom: 60px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}
.blog .entry .entry-img {
  max-height: 440px;
  margin: -30px -30px 20px -30px;
  overflow: hidden;
}
.blog .entry .entry-title {
  font-size: 28px;
  font-weight: bold;
  padding: 0;
  margin: 0 0 20px 0;
}
.blog .entry .entry-title a {
  color: #473d3a;
  transition: 0.3s;
}
.blog .entry .entry-title a:hover {
  color: #ff5821;
}
.blog .entry .entry-meta {
  margin-bottom: 15px;
  color: #afa29e;
}
.blog .entry .entry-meta ul {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  align-items: center;
  padding: 0;
  margin: 0;
}
.blog .entry .entry-meta ul li + li {
  padding-left: 20px;
}
.blog .entry .entry-meta i {
  font-size: 16px;
  margin-right: 8px;
  line-height: 0;
}
.blog .entry .entry-meta a {
  color: #656262;
  font-size: 14px;
  display: inline-block;
  line-height: 1;
}
.blog .entry .entry-content p {
  line-height: 24px;
}
.blog .entry .entry-content .read-more {
  -moz-text-align-last: right;
  text-align-last: right;
}
.blog .entry .entry-content .read-more a {
  display: inline-block;
  background: #ff5821;
  color: #fff;
  padding: 6px 20px;
  transition: 0.3s;
  font-size: 14px;
  border-radius: 4px;
}
.blog .entry .entry-content .read-more a:hover {
  background: #ff6b3b;
}
.blog .entry .entry-content h3 {
  font-size: 22px;
  margin-top: 30px;
  font-weight: bold;
}
.blog .entry .entry-content blockquote {
  overflow: hidden;
  background-color: #fafafa;
  padding: 60px;
  position: relative;
  text-align: center;
  margin: 20px 0;
}
.blog .entry .entry-content blockquote p {
  color: #313030;
  line-height: 1.6;
  margin-bottom: 0;
  font-style: italic;
  font-weight: 500;
  font-size: 22px;
}
.blog .entry .entry-content blockquote::after {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 3px;
  background-color: #473d3a;
  margin-top: 20px;
  margin-bottom: 20px;
}
.blog .entry .entry-footer {
  padding-top: 10px;
  border-top: 1px solid #e6e6e6;
}
.blog .entry .entry-footer i {
  color: #988782;
  display: inline;
}
.blog .entry .entry-footer a {
  color: #554945;
  transition: 0.3s;
}
.blog .entry .entry-footer a:hover {
  color: #ff5821;
}
.blog .entry .entry-footer .cats {
  list-style: none;
  display: inline;
  padding: 0 20px 0 0;
  font-size: 14px;
}
.blog .entry .entry-footer .cats li {
  display: inline-block;
}
.blog .entry .entry-footer .tags {
  list-style: none;
  display: inline;
  padding: 0;
  font-size: 14px;
}
.blog .entry .entry-footer .tags li {
  display: inline-block;
}
.blog .entry .entry-footer .tags li + li::before {
  padding-right: 6px;
  color: #6c757d;
  content: ",";
}
.blog .entry .entry-footer .share {
  font-size: 16px;
}
.blog .entry .entry-footer .share i {
  padding-left: 5px;
}
.blog .entry-single {
  margin-bottom: 30px;
}
.blog .blog-author {
  padding: 20px;
  margin-bottom: 30px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}
.blog .blog-author img {
  width: 120px;
  margin-right: 20px;
}
.blog .blog-author h4 {
  font-weight: 600;
  font-size: 22px;
  margin-bottom: 0px;
  padding: 0;
  color: #473d3a;
}
.blog .blog-author .social-links {
  margin: 0 10px 10px 0;
}
.blog .blog-author .social-links a {
  color: rgba(71, 61, 58, 0.5);
  margin-right: 5px;
}
.blog .blog-author p {
  font-style: italic;
  color: #a4a2a2;
}
.blog .blog-comments {
  margin-bottom: 30px;
}
.blog .blog-comments .comments-count {
  font-weight: bold;
}
.blog .blog-comments .comment {
  margin-top: 30px;
  position: relative;
}
.blog .blog-comments .comment .comment-img {
  margin-right: 14px;
}
.blog .blog-comments .comment .comment-img img {
  width: 60px;
}
.blog .blog-comments .comment h5 {
  font-size: 16px;
  margin-bottom: 2px;
}
.blog .blog-comments .comment h5 a {
  font-weight: bold;
  color: #313030;
  transition: 0.3s;
}
.blog .blog-comments .comment h5 a:hover {
  color: #ff5821;
}
.blog .blog-comments .comment h5 .reply {
  padding-left: 10px;
  color: #473d3a;
}
.blog .blog-comments .comment h5 .reply i {
  font-size: 20px;
}
.blog .blog-comments .comment time {
  display: block;
  font-size: 14px;
  color: #635551;
  margin-bottom: 5px;
}
.blog .blog-comments .comment.comment-reply {
  padding-left: 40px;
}
.blog .blog-comments .reply-form {
  margin-top: 30px;
  padding: 30px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}
.blog .blog-comments .reply-form h4 {
  font-weight: bold;
  font-size: 22px;
}
.blog .blog-comments .reply-form p {
  font-size: 14px;
}
.blog .blog-comments .reply-form input {
  border-radius: 4px;
  padding: 10px 10px;
  font-size: 14px;
}
.blog .blog-comments .reply-form input:focus {
  box-shadow: none;
  border-color: #ffa587;
}
.blog .blog-comments .reply-form textarea {
  border-radius: 4px;
  padding: 10px 10px;
  font-size: 14px;
}
.blog .blog-comments .reply-form textarea:focus {
  box-shadow: none;
  border-color: #ffa587;
}
.blog .blog-comments .reply-form .form-group {
  margin-bottom: 25px;
}
.blog .blog-comments .reply-form .btn-primary {
  border-radius: 4px;
  padding: 10px 20px;
  border: 0;
  background-color: #473d3a;
}
.blog .blog-comments .reply-form .btn-primary:hover {
  background-color: #554945;
}
.blog .blog-pagination {
  color: #7f6d68;
}
.blog .blog-pagination ul {
  display: flex;
  padding: 0;
  margin: 0;
  list-style: none;
}
.blog .blog-pagination li {
  margin: 0 5px;
  transition: 0.3s;
}
.blog .blog-pagination li a {
  color: #473d3a;
  padding: 7px 16px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.blog .blog-pagination li.active, .blog .blog-pagination li:hover {
  background: #ff5821;
}
.blog .blog-pagination li.active a, .blog .blog-pagination li:hover a {
  color: #fff;
}
.blog .sidebar {
  padding: 30px;
  margin: 0 0 60px 20px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}
.blog .sidebar .sidebar-title {
  font-size: 20px;
  font-weight: 700;
  padding: 0 0 0 0;
  margin: 0 0 15px 0;
  color: #473d3a;
  position: relative;
}
.blog .sidebar .sidebar-item {
  margin-bottom: 30px;
}
.blog .sidebar .search-form form {
  background: #fff;
  border: 1px solid #ddd;
  padding: 3px 10px;
  position: relative;
}
.blog .sidebar .search-form form input[type=text] {
  border: 0;
  padding: 4px;
  border-radius: 4px;
  width: calc(100% - 40px);
}
.blog .sidebar .search-form form button {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  border: 0;
  background: none;
  font-size: 16px;
  padding: 0 15px;
  margin: -1px;
  background: #ff5821;
  color: #fff;
  transition: 0.3s;
  border-radius: 0 4px 4px 0;
  line-height: 0;
}
.blog .sidebar .search-form form button i {
  line-height: 0;
}
.blog .sidebar .search-form form button:hover {
  background: #ff6735;
}
.blog .sidebar .categories ul {
  list-style: none;
  padding: 0;
}
.blog .sidebar .categories ul li + li {
  padding-top: 10px;
}
.blog .sidebar .categories ul a {
  color: #473d3a;
  transition: 0.3s;
}
.blog .sidebar .categories ul a:hover {
  color: #ff5821;
}
.blog .sidebar .categories ul a span {
  padding-left: 5px;
  color: #989595;
  font-size: 14px;
}
.blog .sidebar .recent-posts .post-item + .post-item {
  margin-top: 15px;
}
.blog .sidebar .recent-posts img {
  width: 80px;
  float: left;
}
.blog .sidebar .recent-posts h4 {
  font-size: 15px;
  margin-left: 95px;
  font-weight: bold;
}
.blog .sidebar .recent-posts h4 a {
  color: #473d3a;
  transition: 0.3s;
}
.blog .sidebar .recent-posts h4 a:hover {
  color: #ff5821;
}
.blog .sidebar .recent-posts time {
  display: block;
  margin-left: 95px;
  font-style: italic;
  font-size: 14px;
  color: #989595;
}
.blog .sidebar .tags {
  margin-bottom: -10px;
}
.blog .sidebar .tags ul {
  list-style: none;
  padding: 0;
}
.blog .sidebar .tags ul li {
  display: inline-block;
}
.blog .sidebar .tags ul a {
  color: #8d7973;
  font-size: 14px;
  padding: 6px 14px;
  margin: 0 6px 8px 0;
  border: 1px solid #f4f2f2;
  display: inline-block;
  transition: 0.3s;
}
.blog .sidebar .tags ul a:hover {
  color: #fff;
  border: 1px solid #ff5821;
  background: #ff5821;
}
.blog .sidebar .tags ul a span {
  padding-left: 5px;
  color: #ddd7d6;
  font-size: 14px;
}

 
 </style>
  <!-- ======= Top Bar ======= -->
 

  <!-- ======= Header ======= -->
 
  <!-- ======= Hero Section ======= -->
   <!-- End Hero -->

  <main id="main">

     
<section id="hero" class="">

    <div class="hero-content aos-init aos-animate" data-aos="fade-up" style="background-image: url({{asset('images/construction/aboutus.jpg')}});background-repeat:  no-repeat;  background-size: cover;">
      <h2>Build Your <span>Dream Home With</span><br>Tech Enabled Construction</h2>
        
    </div>

    
  </section>
     <section id="about" class="about">
      <div class="container aos-init aos-animate" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2 aos-init aos-animate" data-aos="fade-left" data-aos-delay="100">
            <img src="{{asset('images/construction/imag.jpg')}}" width="100%" height="50%" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
            <h3>WHAT IS BUILDER MART?</h3>
            <p class="fst-italic">
             BUILDER MART is a construction material supply firm situated in Hyderabad that offers both online and offline services.
 		</p> 
 		<p class="fst-italic">	
 		It is the objective of this organization to help individuals save money on home construction by providing them with accurate information about the process, as well as to make purchasing more convenient and easy.
            </p>
             
           <h3>WHY BUILDER MART?</h3>
            <p class="fst-italic">
            Yes, BUILDER MART is required for everyone who is building a home since we provide them with 0 to 100 percent expertise on planning, building, and purchasing the proper items for their needs.
            </p>
 <p class="fst-italic">We help clients save money on construction by recommending the best products at a lower cost, and we sell goods that are purchased straight from the manufacturer.
 </p>
          </div>
        </div>

      </div>
    </section>
    
      <section id="why-us" class="why-us">
      <div class="container">

        <div class="row">
          <div class="col-xl-4 col-lg-5" data-aos="fade-up">
            <div class="content">
              <h3>HOW BUILDER MART WORKS? </h3>
              <p> Builder Mart is based on the idea of saving money on house construction for someone who has worked for a long time and wants to build a house with their retirement or personal funds.
 				</p>
			  <p> We provide three different sorts of building budgets  </p>
             <p>1. ECONOMY, 2. STANDARD, 3. PREMIUM</p>
            </div>
          </div>
          <div class="col-xl-8 col-lg-7 d-flex">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                  <div class="icon-box mt-4 mt-xl-0">
                    <p class="text-dark">From the first stages of structural engineering planning until the house opening ceremony, we are involved.</p>
                     
                   </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                  <div class="icon-box mt-4 mt-xl-0">
                    <p class="text-dark">We provide three estimates for building our clients house depending on quality and pricing based on his budget.</p>
                    
                   </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                  <div class="icon-box mt-4 mt-xl-0">
                    <p class="text-dark">We guarantee that our client he or she will save 5% to 10% of the overall construction cost.</p>
                    </div>
                </div>
            </div>
          </div>
        </div>
		</div>
      </div>
    </section>
    
    
    
    <section id="about" class="about">
      <div class="container aos-init aos-animate" data-aos="fade-up">

        <div class="row">
          
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
            <h5>FIND OUT MORE</h5>
            <h3>HOW TO REACH BUILDER MART?</h3>
            <p class="fst-italic"> It's not an big deal to think! we are available both online and offline. we have our regional office in Pragathi Nagar near JNTU, Hyderabad. you can write your enquires to sales@ buildermart.in and u can also have direct talk with our CEO (ceo@buildermart.in)</p> 
 		<h5>	
 		Who Started BuilderMart? </h5>
          <p class="fst-italic">   Our FOUNDER & CEO, Mr. P N NAMITH, established BUILDER MART in the year 2016. We were incorporated in the year 2021 and registered with the MCA.
 	</p>	
 	<p class="fst-italic">	Despite the fact that we began offering services online in 2021, we have had an offline presence since 2016. We went online to make it easier for our customers to get in touch with us.
            </p>
            
          </div>
          
          <div class="col-lg-6 order-1 order-lg-2 aos-init aos-animate" data-aos="fade-left" data-aos-delay="100">
            <img src="{{asset('images/construction/image.jpg')}}" width="100%" height="50%" class="img-fluid" alt="">
          </div>
        </div>

      </div>
    </section>
    
    <section id="team" class="team section-bg">
      <div class="container">

        <div class="section-title">
          <h2 data-aos="fade-up" class="aos-init aos-animate">Our Executives</h2>
          <p data-aos="fade-up" class="aos-init aos-animate">BUILDER MART is a construction material supply firm situated in Hyderabad that offers both online and offline services. 
          It is the objective of this organisation to help individuals save money on home construction by providing them with accurate information about the process, as well as to make purchasing more convenient and easy.</p>
        </div>

        <div class="row">
        
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up">
            <div class="member">
              <div class="member-img">
                <img src="{{asset('images/construction/Namith_Pullambaku.jpg')}}" width="100%" height="50%" class="img-fluid" alt="Namith_Pullambaku">
                 
              </div>
              <div class="member-info">
                <h4>Namith Pullambaku </h4>
                <span>CEO &amp; Founder</span>
              </div>
            </div>
          </div>
<div class="col-lg-3 col-md-6 " data-aos="fade-up">
           <div class="member">
            <div class="member-info">
          <h4 data-aos="fade-up" class="aos-init aos-animate"> Namith Pullambaku </h4>
          <p data-aos="fade-up" style="text-align: justify;" >Construction is considered the most tech-deficit industry globally. My knowledge and Experience in the field of marketing and civil supplys wasn’t going to be enough if it wasn’t backed by technology in today’s day and age. 
Builder Mart is Going to be the Solution for everything in this Industry.
</div>
          </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <div class="member-img">
                <img src="{{asset('images/construction/Dundi_Gaddigopula.jpg')}}" width="100%" height="50%" class="img-fluid" alt="Dundi_Gaddigopula">
                 
              </div>
              <div class="member-info">
                <h4>Dundi Gaddigopula</h4>
                <span>CMO &amp; Co-Founder</span>
              </div>
            </div>
          </div>

          
<div class="col-lg-3 col-md-6      " data-aos="fade-up">
           <div class="member">
            <div class="member-info">
          <h4 data-aos="fade-up" class="aos-init aos-animate"> Dundi Gaddigopula</h4>
          <p data-aos="fade-up" style="text-align: justify;" >This industry lacks a data-driven approach. With Builder Mart, I saw that we had the potential to convert unorganised to organised and that we were going to be a game changer.</div>
          </div>
          </div>
           

        </div>

      </div>
    </section>
    

  </main>
