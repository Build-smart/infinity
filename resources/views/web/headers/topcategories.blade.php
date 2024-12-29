  
<style>
.dropdown-submenu {
                position: relative;
            }

            .dropdown-submenu> a:after {
                content: ">";
                float: right;
            }
          
 
            .dropdown-submenu>.dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: 0px;
                margin-left: 0px;
            }
         

            .dropdown-submenu:hover>.dropdown-menu {
                display: block;
            }
            
            
            .dropdown-submenu-last {
                position: relative;
            }

            .dropdown-submenu-last> a:after {
                content: ">";
                float: right;
            }
         

            .dropdown-submenu-last>.dropdown-menu {
                top: 0;
                left: -100%;
                margin-top: 0px;
                margin-left: 0px;

}
            .dropdown-submenu-last:hover>.dropdown-menu {
                display: block;
            }  


</style>

           

   

 @if(!empty($result['commonContent']['categories']))
 
 
 
 <div class="container" style="margin-bottom:20px">
<div class="row">
	
                                    @include('web.common.homeMainCategories')
                                    @php    homeMainCategories(); @endphp 
                                
</div>
 
 </div>
 
 
  
   
    @endif
    
    <script>
    $(".btn-group, .dropdown").hover(
            function () {
                $('>.dropdown-menu', this).stop(true, true).fadeIn("fast");
                $(this).addClass('open');
            },
            function () {
                $('>.dropdown-menu', this).stop(true, true).fadeOut("fast");
                $(this).removeClass('open');
            });
    </script>