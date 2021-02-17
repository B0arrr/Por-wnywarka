<?php
$mysql_host = "localhost";
$mysql_database = "porownywarkatest2";
$mysql_user = "root"; //"id15524123_grucha";
$mysql_password = "";//"WieclawLukasz12!";


$arr_Price=null;
$arr_NameOfShop=null;
$shops_count=null;
$arr_Links=null;
$arr_Images=null;
$arr_GameProducent=null;

try {
    $connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    @$name = $_GET['name'];

    $sql = "SELECT DISTINCT Name, Producent,NameOfShop,Price,Link,Image

                FROM `games` G
                JOIN `game_categories` GC ON GC.ID_game = G.ID
                JOIN `categories` C ON GC.ID_category=C.ID
                JOIN `game_shops`GS ON G.ID=GS.ID_game
                JOIN `shops` S ON GS.ID_shop=S.ID
                JOIN `shop_names` SN ON S.ID_shop=SN.ID 
                WHERE Name=:name";

    $query = $connect->prepare($sql);
    $query->bindParam(':name', $name);



    $counter = 0;
    $query -> execute();

    foreach($query as $i)
    {
        $arr_NameOfShop[$counter] = $i['NameOfShop'];
        $arr_Price[$counter] = $i['Price'];
        $arr_Links[$counter]=$i['Link'];
        $arr_Images[$counter]=$i['Image'];
        $arr_GameProducent[$counter]=$i['Producent'];
        $counter++;
    }
    $shops_count=$counter;



} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();

}
$connect = null;
?>