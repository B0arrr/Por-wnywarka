<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <?php
        $mysql_host = "localhost";
        $mysql_database = "id15524123_porownywarka_gier";
        $mysql_user = "id15524123_grucha";
        $mysql_password = "HasloDoBazyDanych12!";
        
        try {
          $connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully" . "<br>";
          
            $sql = "SELECT Name, NameOfCategory, NameOfShop, Price
                        FROM `dbo.Games` AS G 
	                    JOIN `dbo.Shops` AS S ON G.Shop = S.ID
	                    JOIN `dbo.Categories` AS C ON G.Category = C.ID
	                    WHERE G.Description != '...'";
	                    
	       $tmp = $connect->query($sql);

            foreach ($tmp as $row) 
            {
                print $row['Name'] . " ";
                print $row['NameOfCategory'] . " ";
                print $row['NameOfShop'] . " ";
                print $row['Price'] . "<br>";
            }
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
        $conn = null;
    ?>
    
    <div>
        <?php
            $mysql_host = "localhost";
            $mysql_database = "id15524123_porownywarka_gier";
            $mysql_user = "id15524123_grucha";
            $mysql_password = "WieclawLukasz12!";
            
            try {
              $connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
              $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              echo "Connected successfully" . "<br>";
              
                $sql = "SELECT Name, NameOfCategory, NameOfShop, Price
                            FROM `dbo.Games` AS G 
    	                    JOIN `dbo.Shops` AS S ON G.Shop = S.ID
    	                    JOIN `dbo.Categories` AS C ON G.Category = C.ID
    	                    WHERE G.Description != '...'";
    	                    
    	       $tmp = $connect->query($sql);
    
                foreach ($tmp as $row) 
                {
                    print $row['Name'] . " ";
                    print $row['NameOfCategory'] . " ";
                    print $row['NameOfShop'] . " ";
                    print $row['Price'] . "<br>";
                }
            } catch(PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
            }
            $conn = null;
        ?>
    </div>
    
</body>
</html>
