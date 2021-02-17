<?php
    $limit = 18;
    
    $page = 1;
    
    $start = 0;
    
    if(@$_GET['page'] > 1)
    {
      $start = ((@$_GET['page'] - 1) * $limit);
      $page = @$_GET['page'];
    }
    
    $end = $start + $limit;
    
    require 'queries.php';
    
    $output = null;

    $counter = 0;
    
    for($i = 0; $i < $limit; $i++)
    {
        if($result_count == (($page-1)*$limit)+$i) break;

        $output .= '<a href="javascript:void(0)" class="text-decoration-none text-reset" >
        <div class="col">
            <div class="card bg-dark border-0" style="width: 20rem;">
                <img class="card-img-top" src="';
                    $output.= $arr_Images[$i];
                    $output.= '" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title" title="';
                        $output .= $arr_Name[$i];
                        $output .= '">';
                        $output .= $arr_Name[$i];
                    $output .= '</h5>
                    <p class="card-text" title="';
                        $output .= $arr_Producent[$i];
                        $output .= '">';
                        $output .= $arr_Producent[$i];
                    $output .= '</p>
                    <h6>';
                        $output .= $arr_Prices[$i];
                    $output .=' zł</h6>
                </div>
            </div>
        </div></a>';
        $counter++;
    }

    print $output;
    
    $total_links = ceil($result_count/$limit);
    $previous_link = '';
    $next_link = '';
    $page_link = '';
    $page_array = [];
    
    $output = '
        <div class="col-md-6 offset-3">
          <ul class="pagination">
        ';
    
    if($total_links > 5)
    {
      if($page < 5)
      {
        for($count = 1; $count <= 5; $count++)
        {
          $page_array[] = $count;
        }
        $page_array[] = '...';
        $page_array[] = $total_links;
      }
      else
      {
        $end_limit = $total_links - 5;
        if($page > $end_limit)
        {
          $page_array[] = 1;
          $page_array[] = '...';
          for($count = $end_limit; $count <= $total_links; $count++)
          {
            $page_array[] = $count;
          }
        }
        else
        {
          $page_array[] = 1;
          $page_array[] = '...';
          for($count = $page - 1; $count <= $page + 1; $count++)
          {
            $page_array[] = $count;
          }
          $page_array[] = '...';
          $page_array[] = $total_links;
        }
      }
    }
    else
    {
      for($count = 1; $count <= $total_links; $count++)
      {
        $page_array[] = $count;
      }
    }
    
    for($count = 0; $count < count($page_array); $count++)
    {
      if($page == $page_array[$count])
      {
        $page_link .= '
        <li class="page-item active">
          <a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
        </li>
        ';
    
        $previous_id = $page_array[$count] - 1;
        if($previous_id > 0)
        {
          $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
        }
        else
        {
          $previous_link = '
          <li class="page-item disabled">
            <a class="page-link" href="">Previous</a>
          </li>
          ';
        }
        $next_id = $page_array[$count] + 1;
        if($next_id >= $total_links + 1)
        {
          $next_link = '
          <li class="page-item disabled">
            <a class="page-link" href="">Next</a>
          </li>
            ';
        }
        else
        {
          $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
        }
      }
      else
      {
        if($page_array[$count] == '...')
        {
          $page_link .= '
          <li class="page-item disabled">
              <a class="page-link" href="">...</a>
          </li>
          ';
        }
        else
        {
          $page_link .= '
          <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
          ';
        }
      }
    }
    
    $output .= $previous_link . $page_link . $next_link;
    $output .= '
      </ul>
    </div>
    ';
    
    echo $output;
?>