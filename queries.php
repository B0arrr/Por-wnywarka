<?php
$mysql_host = "localhost";
$mysql_database = "id15524123_porownywarka_gier";
$mysql_user = "id15524123_grucha";
$mysql_password = "WieclawLukasz12!";

$arr_Name = null;
$arr_Producent = null;

$result_count = 0;

try {
    $connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    @$category= $_GET['NameOfCategory'];
    @$shop= $_GET['NameOfShop'];
    @$producent= $_GET['Producent'];
  
    $category == '' ? $b_category = 0 : $b_category = 1;
    $shop == '' ? $b_shop = 0 : $b_shop = 1;
    $producent == '' ? $b_producent = 0 : $b_producent = 1;
    
    if (!$b_category && !$b_shop && !$b_producent)
    {   
        $sql= "SELECT Name, Producent
                FROM `dbo.Games` LIMIT {$start}, {$end}";
        $counter = "SELECT COUNT(Name) AS Counter
                        FROM `dbo.Games`";
    }
    
    else if ($b_category && $b_shop && $b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                    INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                    WHERE NameOfCategory = {$category} AND NameOfShop = {$shop} AND Producent = {$producent} 
                    LIMIT {$start}, {$end}";
        $counter = "SELECT COUNT(Name) AS Counter
                        FROM `dbo.Games`
                        INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                        INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                        WHERE NameOfCategory = {$category} AND NameOfShop = {$shop}
                        AND Producent = {$producent}";
    }
    
    else if ($b_category && $b_shop && !$b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                    INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                    WHERE NameOfCategory = {$category} AND NameOfShop = {$shop} 
                    LIMIT {$start}, {$end}";
        $counter = "SELECT COUNT(Name) AS Counter
                        FROM `dbo.Games`
                        INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                        INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                        WHERE NameOfCategory = {$category} AND NameOfShop = {$shop}";
    }
    
    else if ($b_category && !$b_shop && $b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                    WHERE NameOfCategory = {$category}  AND Producent = {$producent} 
                    LIMIT {$start}, {$end}";
        $counter = "SELECT COUNT(Name) AS Counter
                        FROM `dbo.Games`
                        INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                        WHERE NameOfCategory = {$category}  AND Producent = {$producent}";
    }
    
    else if (!$b_category && $b_shop && $b_producent)
    {
        $sql = "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                    WHERE  NameOfShop = {$shop} AND Producent = {$producent} 
                    LIMIT {$start}, {$end}";
        $counter =  "SELECT COUNT(Name) AS Counter
                        FROM `dbo.Games`
                        INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                        WHERE  NameOfShop = {$shop} AND Producent = {$producent}";
    }
    
    else if ($b_category && !$b_shop && !$b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`  
                    INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                    WHERE NameOfCategory = {$category} 
                    LIMIT {$start}, {$end}";
        $counter = "SELECT COUNT(Name) AS Counter
                        FROM `dbo.Games`  
                        INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                        WHERE NameOfCategory = {$category}";
    }
   
    else if (!$b_category && !$b_shop && $b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`  
                    WHERE Producent = {$producent} 
                    LIMIT {$start}, {$end}";
        $counter = "SELECT COUNT(Name) AS Counter
                        FROM `dbo.Games`  
                        WHERE Producent = {$producent}";
    }
    
    else if (!$b_category && $b_shop && !$b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                    WHERE NameOfShop = {$shop} 
                    LIMIT {$start}, {$end}";
        $counter = "SELECT COUNT(Name) AS Counter
                        FROM `dbo.Games`
                        INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                        WHERE NameOfShop = {$shop}";
    }

    $query = $connect->prepare($sql);
    $query_count = $connect->prepare($counter);
    
    $counter = 0;
    
    $query -> execute();
    
    foreach($query as $i)
    {
        $arr_Name[$counter] = $i['Name'];
        $arr_Producent[$counter] = $i['Producent'];
        $counter++;
    }
    
    $query_count -> execute();
    
    //$counter = 0;
    
    foreach($query_count as $i)
    {
        $counter = $i['Counter'];
    }
    
    $result_count = $counter;

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    
}
$connect = null;
?>