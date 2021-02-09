<?php
$mysql_host = "localhost";
$mysql_database = "porownywarkatest2";
$mysql_user = "root";//"id15524123_grucha";
$mysql_password = "";//"WieclawLukasz12!";

$filename= "games.json";
$data=file_get_contents($filename);
$games=json_decode($data,true);


try
{
    $conn = new PDO("mysql:host=$mysql_host;dbname=$mysql_database;charset=utf8", $mysql_user, $mysql_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach(array_keys($games) as $i)
    {
        $shop=null;
        if($i=='steam')
            $shop= 'Steam';
        else if ($i=='epicgames')
            $shop= 'Epic Games Store';

        $sql_shop_name="SELECT ID From `shop_names` WHERE NameOfShop='{$shop}' ";
        $sql_shop_name_query = $conn->prepare($sql_shop_name);
        $sql_shop_name_query -> execute();
        $id_shop_name=null;
        foreach($sql_shop_name_query as $p)
        {
            $id_shop_name=$p['ID'];
        }
        if($id_shop_name == null)
        {
            $sql_shop_name_id="SELECT MAX(ID) AS maxid From `shop_names` ";
            $sql_shop_name_id_query = $conn->prepare($sql_shop_name_id);
            $sql_shop_name_id_query -> execute();

            foreach($sql_shop_name_id_query as $r)
            {
                $id_shop_name=$r['maxid'];
            }
            if($id_shop_name=='')
            {
                $id_shop_name=1;
            }else
            {
                $id_shop_name++;
            }
            $sql_append_shop = "INSERT INTO `shop_names` VALUES ({$id_shop_name},:name)";
            $sql_append_shop_query = $conn->prepare($sql_append_shop);
            $sql_append_shop_query->bindParam(':name', $shop);
            $sql_append_shop_query -> execute();
        }


        foreach ($games[$i] as $j)
        {
            $name =  $j['name'];
            $price = $j['price'];
            $price = str_replace("zł","",$price);
            $price = str_replace(",",".",$price);
            $price = (double)$price;
            $link = $j['link'];
            $categories = null;
            $counter=0;
            foreach ($j['categories'] as $k)
            {
                $categories[$counter] = $k;
                $counter++;
            }
            $producent = $j['producent'];

            $id_game = null;
            $id_categories = null;
            $id_shop_names=null;
            $id = '';
            $counter=0;

            $sql_game = "SELECT  ID FROM `games` WHERE Name = :name";
            $sql_game_query = $conn->prepare($sql_game);
            $sql_game_query->bindParam(':name', $name);
            $sql_game_query -> execute();
            foreach($sql_game_query as $o)
            {
                $id_game=$o['ID'];

            }
            if($id_game == null)
            {


                $sql_game_id = "SELECT MAX(ID) AS maxid From `games` ";
                $sql_id_game_query = $conn->prepare($sql_game_id);
                $sql_id_game_query->execute();

                foreach ($sql_id_game_query as $n)
                {
                    $id_game = $n['maxid'];
                }
                if ($id_game == '')
                {
                    $id_game = 1;
                } else
                {
                    $id_game++;
                }
                $sql_append_game = "INSERT INTO `games` VALUES ({$id_game},:name,:producent)";
                $sql_append_game_query = $conn->prepare($sql_append_game);
                $sql_append_game_query->bindParam(':name', $name);
                $sql_append_game_query->bindParam(':producent', $producent);
                $sql_append_game_query->execute();


                foreach ($categories as $k)
                {
                    $id = '';
                    $sql_id = "SELECT  ID FROM `categories` WHERE Category = '{$k}'";
                    $id_query = $conn->prepare($sql_id);
                    $id_query->execute();
                    $id_count = 0;
                    foreach ($id_query as $chuj)
                    {
                        $id = $chuj['ID'];

                    }


                    if ($id == '')
                    {
                        $sql_min_cat = "SELECT MAX(ID) AS maxid FROM `categories`";
                        $min_category = $conn->prepare($sql_min_cat);
                        $min_category->execute();
                        foreach ($min_category as $chuj)
                        {
                            $id = $chuj['maxid'];


                        }
                        if ($id == '')
                        {
                            $id = 1;
                        } else
                        {
                            $id++;
                        }

                        $sql_append_category = "INSERT INTO `categories` (ID,Category) VALUES ($id,:category)";
                        $sql_append_category_query = $conn->prepare($sql_append_category);
                        $sql_append_category_query->bindParam(':category', $k);
                        $sql_append_category_query->execute();
                    }

                    $id_categories[$counter] = $id;
                    $counter++;
                }
                foreach ($id_categories as $m)
                {
                    $sql_append_game_category = "INSERT INTO `game_categories` VALUES ({$id_game},{$m})";
                    $sql_append_game_category_query = $conn->prepare($sql_append_game_category);
                    $sql_append_game_category_query->execute();

                }
            }

            $sql_presence_game_in_shop= "SELECT Name 
                                            FROM `games` G
                                                JOIN `game_shops` GS ON G.ID=Gs.ID_game
                                                JOIN `shops` S ON GS.ID_shop=S.ID
                                                JOIN `shop_names` SN ON S.ID_shop=SN.ID
                                            WHERE NameOfShop= '{$shop}' AND Name= :Name ";
            $sql_presence_game_in_shop_query = $conn->prepare($sql_presence_game_in_shop);
            $sql_presence_game_in_shop_query->bindParam(':Name', $name);
            $sql_presence_game_in_shop_query->execute();
            $tmp_presence=null;

            foreach($sql_presence_game_in_shop_query as $t)
            {
                $tmp_presence=$t['Name'];
            }


            if ($tmp_presence=='')
            {
                $sql_shops_id = "SELECT MAX(ID) AS maxid From `shops` ";
                $sql_shops_id_query = $conn->prepare($sql_shops_id);
                $sql_shops_id_query->execute();

                foreach ($sql_shops_id_query as $s)
                {
                    $id_shops = $s['maxid'];
                }
                if ($id_shops == '')
                {
                    $id_shops = 1;
                } else
                {
                    $id_shops++;
                }
                print $id_shops;

                $sql_append_shops = "INSERT INTO `shops` VALUES ({$id_shops}, {$id_shop_name}, {$price}, :link)";
                $sql_append_shops_query = $conn->prepare($sql_append_shops);
                $sql_append_shops_query->bindParam(':link', $link);
                $sql_append_shops_query->execute();

                $sql_append_game_shop = "INSERT INTO `game_shops` VALUES ({$id_game},{$id_shops})";
                $sql_append_game_shop_query = $conn->prepare($sql_append_game_shop);
                $sql_append_game_shop_query->execute();

            }

            $sql_game_price_in_database= "SELECT Price AS database_price FROM `shops`
                                        WHERE  ID ={$id_shops} AND ID_shop= {$id_shop_name} ";
            $sql_game_price_in_query = $conn->prepare($sql_game_price_in_database);
            $sql_game_price_in_query->execute();

            foreach ($sql_game_price_in_query as $b)
            {
                $game_price_in_database = $b['database_price'];
            }

            if($tmp_presence!='' && $price!= $game_price_in_database)
            {
                $sql_game_price_in_database_change= "UPDATE `shops` SET `Price` = '{$price}'
                                                         WHERE  ID ={$id_shops} AND ID_shop= {$id_shop_name};";
                $sql_game_price_in_database_change_query = $conn->prepare($sql_game_price_in_database_change);
                $sql_game_price_in_database_change_query>execute();
            }
        }

    }
} catch (PDOException $e){
    print $e->getMessage();
}

?>