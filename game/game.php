<?php
require "gamequeries.php";
$name = $_GET['name'];
$merged_array=array_merge($arr_Links,$arr_NameOfShop,$arr_Price);
$array_counter=count($merged_array)/3;

$output = '<div class="container   min-vh-100">
                <div class="row pb-5" >
                    <button type="button" class="btn btn-secondary" id="Goback">GoBack</button>
                </div>
            <div id="Game" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
     <h1 class="h4">';

$output .= $name;

$output .= '</h1>
   </div>
    <div class="row h-100">

        <div class=" float-left pl-5 ">
            <div class="card border-0 bg-dark" style="width: 18rem;">
                  <img class="card-img-top" src="';
$output.= $arr_Images[0];
$output.='" alt="Card image cap">
              <div class="card-body"> 
              <h5>' ;
$output.= $arr_GameProducent[0];
$output.= '</h5>
              </div>
            </div>

        </div>
        <div class="col-md-6 mx-auto pl-5 ">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-white">Prices</span>
            <span class="badge badge-secondary badge-pill">';
$output .= $shops_count;
$output .=' </span>
          </h4>';

    $output .= '<ul class="list-group mb-3">';
$temp=0;
for($i=0;$i<$array_counter;$i++) {
   
    $temp=$i;

    $output .= ' <a style="text-decorations:none; color:white" href="';
    $output .= $merged_array[$temp];
    $temp+=$array_counter;
    $output .= '" target="_blank"><li class="list-group-item d-flex justify-content-between lh-condensed bg-dark border-white">
              <div>
                <h6 class="my-0">';
    $output .= $merged_array[$temp];
    $temp+=$array_counter;
    $output .= '</h6>

              </div>
              <span class="text-white">';
    $output .=  $merged_array[$temp];
    $output.= 'zł';
    $output .= ' </span>
            </li></a>';
}
    $output .= '</ul>
           <p>
               
           </p>
        </div>
    </div>
</div>';


print $output;
?>