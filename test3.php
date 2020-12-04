<?php
    require 'test2.php';
    
    for($i = 0; $i < 18; $i++)
    {
        print '<a href="game.html" class="text-decoration-none text-reset" ><div class="col">
            <div class="card" style="width: 20rem;">
            <img class="card-img-top" src="img/cs1.jpg" alt="Card image cap">
            <div class="card-body">
            <h5 class="card-title">'
        .$arr_Name[$i]
        .'</h5>
            <p class="card-text">'
        .$arr_Producent[$i]
        .'</p>
        </div>
        </div>
        </div></a>';
    }
?>