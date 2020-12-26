<?php

$name = $_GET['name'];

$output = '
   <div id="Game" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
     <h1 class="h4">';

$output .= $name;

$output .= '</h1>
   </div>
    <div class="row h-100">
       
        <div class=" float-left pl-5 ">
            <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="" alt="Card image cap">
              <div class="card-body">   
              </div>
            </div>
            
        </div>
        <div class="col-md-6 mx-auto pl-5 ">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Prices</span>
            <span class="badge badge-secondary badge-pill">3</span>
          </h4>
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">Sklep 1</h6>
               
              </div>
              <span class="text-muted">$12</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">Sklep2</h6>
                
              </div>
              <span class="text-muted">$8</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">Sklep2</h6>
                
              </div>
              <span class="text-muted">$5</span>
          </ul>
           <p>
               Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
           </p>
        </div>
    </div>';

print $output;
?>