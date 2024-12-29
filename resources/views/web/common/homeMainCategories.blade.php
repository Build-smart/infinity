<?php

 function homeMainCategories(){
  $categories = homeMainRecursivecategories();
  if($categories){
  $parent_id = 0;
  $option = '';
    $catcount=0;
   // dd($categories);
    foreach($categories as $parents){
$catcount=$catcount+1;
     $parent_slug  = $parents->slug;
     

     if(isset($parents->childs)){
        $hasChild = "href=#".$parents->slug."  data-toggle='collapse' role='button' aria-expanded='false' "; 
      }else {
        $hasChild = "href=".url('shop?category=').$parents->slug;;
      }
     
      $option .= '
 
		<div class="col-lg-2">
                  
                            <div class="btn-group">
                               
 
       <a  role="button" data-toggle="dropdown" class=" dropdown-toggle text-dark text-center" '. $hasChild .'> <img class="img-fluid bordershadow" src="'.asset($parents->path).'"><br><br>'.$parents->categories_name.'</a>
    
       	
       		
       		
       	 	 

      
       		';

        if(isset($parents->childs)){
          $total = '';
          $i = 1;
          $option.=' <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" id="'.$parent_slug.'">
                       
          		
          		';
          $option .= homeMainChildcat($parents->childs, $i, $parent_id,$catcount);
           $option.='</ul></div> </div> ';
        }

    }

  echo $option;
}
}
 function homeMainChildcat($childs, $i, $parent_id,$catcount){

  $contents = '';
  
  $submenucontents='';
  $submenu='';
  foreach($childs as $key => $child){
    $dash = '';
    for($j=1; $j<=$i; $j++){
        $dash .=  '&nbsp;';
        
    }
    
 
    
    
    
    if(isset($child->childs)){
      $k = $i+1;


      if($i==1){
      	 
     	if($catcount==6){
      		$submenucontents.= '<li class="dropdown-submenu-last">
        <a class="dropdown-item" tabindex="-1" href='.url('shop?category=').$child->slug.' > '.$dash.'
            '.$child->categories_name.'
        </a>
      ';
      		
      	}else{
      		$submenucontents.= '<li class="dropdown-submenu">
        <a class="dropdown-item" tabindex="-1" href='.url('shop?category=').$child->slug.' > '.$dash.'
            '.$child->categories_name.'
        </a>
      ';
      	}
      }
      
     $submenu=$submenucontents.' <ul class="dropdown-menu">';
      
      $submenu.= homeMainChildcat($child->childs,$k,$parent_id,$catcount)."</li>  </ul>";
      $contents.=$submenu;
      
     
    }
    elseif($i>0){
    	
    	$contents.= '<li>
        <a class="dropdown-item" href='.url('shop?category=').$child->slug.' > '.$dash.'
            '.$child->categories_name.'
        </a>
    	
    	
    	
      </li>';
    	
      $i=1;
      $submenucontents='';
      $submenu='';
     
    }
 $submenucontents='';
      $submenu='';
    //$contents.=$submenu;

  }
  return $contents;
}


 function homeMainRecursivecategories(){
  $items = DB::table('categories')
      ->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
      ->leftJoin('image_categories', 'categories.categories_icon', '=', 'image_categories.image_id')
      ->select('categories.categories_id', 'categories.categories_slug as slug', 'image_categories.path as path', 'categories_description.categories_name', 'categories.parent_id', 'categories.categories_status')
      ->where('categories_description.language_id','=', Session::get('language_id'))
      ->where('categories.categories_status','=', 1)
              ->where('categories.categories_id','!=', 132)

    
      ->groupBy('categories.categories_id')
      
      ->get();
   if($items->isNotEmpty()){
      $childs = array();

      foreach($items as $item)
          $childs[$item->parent_id][] = $item;

      foreach($items as $item) if (isset($childs[$item->categories_id]))
          $item->childs = $childs[$item->categories_id];

      $tree = $childs[0];
      return  $tree;
    }
}

 ?>
