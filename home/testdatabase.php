<?php
$mysql_host = "localhost";
$mysql_database = "porownywarkatest";
$mysql_user = "root";//"id15524123_grucha";
$mysql_password = "";//"WieclawLukasz12!";

$filename= "games.json";
$data=file_get_contents($filename);
$games=json_decode($data,true);
//print_r ($games);
//try {
foreach($games as $i)
{
    $connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    foreach ($i as $j)
    {
        $name =  $j['name'];
        $price = $j['price'];
        $link = $j['link'];
        $categories = null;
        $counter = 0;

        foreach ($j['categories'] as $k)
        {
            $categories[$counter] = $k;
            $counter++;
        }

        $producent = $j['producent'];

        //$sql = "INSERT INTO `dbo.categories` (NameOfCategory) VALUES ('$categories[]')";
       // $sql = "INSERT INTO `dbo.categories` (NameOfCategory) VALUES ('$categories[0]')";

//        $sql = "SELECT COUNT(NameOfCategory) FROM `dbo.categories` WHERE NameOfCategory = {$categories[0]}";
//
//        if ($sql == 0)
//        {
//            $sql = "INSERT INTO `dbo.categories` (NameOfCategory) VALUES ('$categories[0]')";
//        }
        //$sql = "INSERT INTO `dbo.categories` (NameOfCategory) VALUES ('$categories[0]')";

   // }
    //foreach ($categories as $l)
    //{
        //$sql = "SELECT COUNT(NameOfCategory) FROM `dbo.categories` WHERE NameOfCategory = {$categories[$l]}";

        //if ($sql == 0)
        //{

            //$sql = "INSERT INTO `dbo.categories` (NameOfCategory) VALUES ('$categories[$l]')";
        //}
    //}
    print_r($categories);
    //$query = $connect->prepare($sql);
    //$query -> execute();
}
//} catch(PDOException $e) {
 // echo "Connection failed: " . $e->getMessage();

//$result_count = 0;
//
//try {
//    $connect = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
//    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//
//
//    $query = $connect->prepare($sql);
//
//
//
//
//    $query -> execute();





//} catch(PDOException $e) {
//    echo "Connection failed: " . $e->getMessage();

}
$connect = null;
?>