<?php
    $mysql_host = "localhost";
    $mysql_database = "id15524123_porownywarka_gier";
    $mysql_user = "id15524123_grucha";
    $mysql_password = "WieclawLukasz12!";
    
    $arr_Name = null;
    $arr_Description = null;
    
    try {
      $connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $sql = "SELECT Name, Description FROM `dbo.Games`";
                    
       $query = $connect->query($sql);
       
       $counter = 0;

        foreach($query as $tmp)
        {
            $arr_Name[$counter] = $tmp['Name'];
            $arr_Description[$counter] = $tmp['Description'];
            $counter++;
        }
        
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
?>