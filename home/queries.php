<?php
$mysql_host = "localhost";
$mysql_database = "id15524123_porownywarka_gier";
$mysql_user = "root";//"id15524123_grucha";
$mysql_password = "";//"WieclawLukasz12!";

$arr_Name = null;
$arr_Producent = null;

$result_count = 0;

try {
    $connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $_GET['category'] != '' ? $_GET['NameOfCategory'] = $_GET['category']: $_GET['NameOfCategory'] = '';
    $_GET['shop'] != '' ? $_GET['NameOfShop'] = $_GET['shop']: $_GET['NameOfShop'] = '';
    $_GET['producent'] != '' ? $_GET['Producent'] = $_GET['producent']: $_GET['Producent'] = '';

    @$category = $_GET['NameOfCategory'];
    @$shop = $_GET['NameOfShop'];
    @$producent = $_GET['Producent'];
  
    $category == '' ? $b_category = 0 : $b_category = 1;
    $shop == '' ? $b_shop = 0 : $b_shop = 1;
    $producent == '' ? $b_producent = 0 : $b_producent = 1;

    $sql = "SELECT Name, Producent
                FROM `dbo.Games` G
                JOIN `dbo.categories` C ON C.ID = G.Category
                JOIN `dbo.shops` S ON S.ID = G.Shop ";
    $counter = "SELECT COUNT(DISTINCT Name) AS Counter
                        FROM `dbo.Games` G
                        JOIN `dbo.categories` C ON C.ID = G.Category
                        JOIN `dbo.shops` S ON S.ID = G.Shop ";
    $sql_counter = 0;
    if($b_category)
    {
        $sql .= "WHERE NameOfCategory = '{$category}' ";
        $counter .= "WHERE NameOfCategory = '{$category}' ";
        $sql_counter++;
    }
    if($b_producent)
    {
        $sql_counter > 0 ? $sql .= "AND Producent = '{$producent}' ": $sql .= "WHERE Producent = '{$producent}' ";
        $sql_counter > 0 ? $counter .= "AND Producent = '{$producent}' ": $counter .= "WHERE Producent = '{$producent}' ";
        $sql_counter++;
    }
    if($b_shop)
    {
        $sql_counter > 0 ? $sql .= "AND NameOfShop = '{$shop}' ": $sql .= "WHERE NameOfShop = '{$shop}' ";
        $sql_counter > 0 ? $counter .= "AND NameOfShop = '{$shop}' ": $counter .= "WHERE NameOfShop = '{$shop}' ";
    }

    $sql .= "LIMIT {$start}, {$end}";

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