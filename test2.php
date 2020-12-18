<?php
$mysql_host = "localhost";
$mysql_database = "id15524123_porownywarka_gier";
$mysql_user = "id15524123_grucha";
$mysql_password = "WieclawLukasz12!";

$arr_Name = null;
$arr_Producent = null;
$resultcount=null;

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
                    FROM `dbo.Games`";
    }
    
    else if ($b_category && $b_shop && $b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                    INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                    WHERE NameOfCategory = '$category' AND NameOfShop = '$shop' AND Producent = '$producent'";
    }
    
    else if ($b_category && $b_shop && !$b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                    INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                    WHERE NameOfCategory = '$category' AND NameOfShop = '$shop'";
    }
    
    else if ($b_category && !$b_shop && $b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                    WHERE NameOfCategory = '$category'  AND Producent = '$producent'  ";
    }
    
    else if (!$b_category && $b_shop && $b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                    WHERE  NameOfShop = '$shop' AND Producent = '$producent' ";
    }
    
    else if ($b_category && !$b_shop && !$b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`  
                    INNER JOIN `dbo.Categories`  ON `dbo.Games`.Category = `dbo.Categories`.ID
                    WHERE NameOfCategory = '$category'";
    }
   
    else if (!$b_category && !$b_shop && $b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`  
                    WHERE Producent = '$producent' ";
    }
    
    else if (!$b_category && $b_shop && !$b_producent)
    {
        $sql= "SELECT Name, Producent
                    FROM `dbo.Games`
                    INNER JOIN `dbo.Shops` ON `dbo.Games`.Shop=`dbo.Shops`.ID
                    WHERE NameOfShop = '$shop' ";
    }
   
    

    $query = $connect->query($sql);

    $counter = 0;

    foreach($query as $tmp)
    {
        $arr_Name[$counter] = $tmp['Name'];
        $arr_Description[$counter] = $tmp['Producent'];
        $counter++;
    }
    
    $resultcount=$counter;

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    
}
$conn = null;
?>