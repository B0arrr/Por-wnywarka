<?php
require "select.php";

$output = '
			<div class="row pb-5">
              <div class="col-md-2 mb-2">
                <select id="categories" class="custom-select d-block w-100" name="NameOfCategory">';

$output .= '<option value="">Kategoria...</option>';
                  
foreach($arr_Category as $item)
{
    $output .= '<option value="'.$item.'">'.$item.'</option>';
}

$output .= '
    </select>
        <div class="invalid-feedback">
          Please select a valid category.
        </div>
      </div>
      <div class="col-md-2 mb-2">
        <select id="producents" class="custom-select d-block w-100" name="Producent" >
                <option value="">Producent...</option>';
                  
foreach($arr_Producent as $item)
{
    $output .= '<option value="'.$item.'">'.$item.'</option>';
}

$output .= '
			</select>
                <div class="invalid-feedback">
                  Please provide a valid producent.
                </div>
              </div>
              <div class="col-md-2 mb-2">
                <select id="shops" class="custom-select d-block w-100" name="NameOfShop" >
				<option value="">Sklep...</option>';
                  
foreach($arr_Shop as $item)
{
  $output .= '<option value="'.$item.'">'.$item.'</option>';
}
  
$output .= '
			</select>
                <div class="invalid-feedback">
                  Please provide a valid sklep.
                </div>
              </div>
              
            <div class="col-md-4 mb-2">
                <input id="search-box" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button type="submit" class="btn btn-secondary">Search</button>
            </div>
        </div>';

print $output;
?>