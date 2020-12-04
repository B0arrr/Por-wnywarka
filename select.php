<?php
    $mysql_host = "localhost";
    $mysql_database = "id15524123_porownywarka_gier";
    $mysql_user = "id15524123_grucha";
    $mysql_password = "HasloDoBazyDanych12!";
    
    $arr_Name = null;
    $arr_Producent = null;
    $arr_Shop=null;
    
    
    
    try {
      $connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $sql = "SELECT DISTINCT NameOfCategory FROM `dbo.Categories`";
                    
       $query = $connect->query($sql);
       
       $counter = 0;

        foreach($query as $tmp)
        {
            $arr_Category[$counter] = $tmp['NameOfCategory'];
           
            $counter++;
        }
        
         $sql = "SELECT DISTINCT NameOfShop FROM `dbo.Shops`";
                    
       $query = $connect->query($sql);
       
       $counter = 0;

        foreach($query as $tmp)
        {
            $arr_Shop[$counter] = $tmp['NameOfShop'];
           
            $counter++;
        }
        
          $sql = "SELECT DISTINCT Producent FROM `dbo.Games`";
                    
       $query = $connect->query($sql);
       
       $counter = 0;

        foreach($query as $tmp)
        {
            $arr_Producent[$counter] = $tmp['Producent'];
           
            $counter++;
        }
        
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
?>