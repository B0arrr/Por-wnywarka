<?php
$mysql_host = "localhost";
$mysql_database = "porownywarkatest2";
$mysql_user = "root";//"id15524123_grucha";
$mysql_password = "";//"WieclawLukasz12!";

$arr_Name = null;
$arr_Producent = null;
$arr_Images=null;
$arr_prices=null;

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
    @$search = $_GET['search'];
    $category == '' ? $b_category = 0 : $b_category = 1;
    $shop == '' ? $b_shop = 0 : $b_shop = 1;
    $producent == '' ? $b_producent = 0 : $b_producent = 1;
    $search == '' ? $b_search = 0 : $b_search = 1;

    $sql = "SELECT DISTINCT Name, Producent,Image, MIN(Price) AS Price
                FROM `games` G
                JOIN `game_categories` GC ON GC.ID_game = G.ID
                JOIN `categories` C ON GC.ID_category=C.ID
                JOIN `game_shops`GS ON G.ID=GS.ID_game
                JOIN `shops` S ON GS.ID_shop=S.ID
                JOIN `shop_names` SN ON S.ID_shop=SN.ID ";

    $counter = "SELECT  COUNT(DISTINCT Name) AS Counter
                         FROM `games` G
                JOIN `game_categories` GC ON GC.ID_game = G.ID
                JOIN `categories` C ON GC.ID_category=C.ID
                JOIN `game_shops`GS ON G.ID=GS.ID_game
                JOIN `shops` S ON GS.ID_shop=S.ID
                JOIN `shop_names` SN ON S.ID_shop=SN.ID ";
    $sql_counter = 0;
    if($search=='')
    {
        if ($b_category)
        {
            $sql .= "WHERE Category = :category ";
            $counter .= "WHERE Category = :category ";
            $sql_counter++;
        }
        if ($b_producent)
        {
            $sql_counter > 0 ? $sql .= "AND Producent = :producent " : $sql .= "WHERE Producent = :producent ";
            $sql_counter > 0 ? $counter .= "AND Producent = :producent " : $counter .= "WHERE Producent = :producent ";
            $sql_counter++;
        }
        if ($b_shop)
        {
            $sql_counter > 0 ? $sql .= "AND NameOfShop = :shop " : $sql .= "WHERE NameOfShop = :shop  ";
            $sql_counter > 0 ? $counter .= "AND NameOfShop = :shop  " : $counter .= "WHERE NameOfShop = :shop  ";
        }
    }else
    {
        $sql .= "WHERE Name LIKE CONCAT('%', :search, '%') ";
        $counter.= "WHERE Name LIKE CONCAT('%', :search, '%') ";
    }
    $sql .= "GROUP BY Name, Producent,Image LIMIT {$start}, {$end}";

    $query = $connect->prepare($sql);
    $query_count = $connect->prepare($counter);

    if($search=='')
    {
        if ($b_category)
        {
            $query->bindParam(':category', $category);
            $query_count->bindParam(':category', $category);
        }
        if ($b_producent)
        {
            $query->bindParam(':producent', $producent);
            $query_count->bindParam(':producent', $producent);
        }
        if ($b_shop)
        {
            $query->bindParam(':shop', $shop);
            $query_count->bindParam(':shop', $shop);
        }
    }else
    {
        $query->bindParam(':search', $search);
        $query_count->bindParam(':search', $search);
    }

    $counter = 0;

    $query -> execute();

    foreach($query as $i)
    {
        $arr_Name[$counter] = $i['Name'];
        $arr_Producent[$counter] = $i['Producent'];
        $arr_Images[$counter] = $i['Image'];
        $arr_Prices[$counter] = $i['Price'];
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