
<?php
require "../../models/eventModel.php";
require "../../config/globals.php";
require "../../config/db.php";

$conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
$Event = new Event($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if(key_exists("title" , $_GET)){
        $title = $_GET["title"];
        session_start();
        if($_SESSION && key_exists("username" , $_SESSION)){

            $res = $Event->addWishList($title , $_SESSION["username"]);

            if ($res){
                echo json_encode(array("status" => "success" , "message"=>"added succesfully at the wish list"));
                
            }else{
                echo json_encode(array("status" => "fail" , "message"=>"something went wrong. Maybe you already have this event in you wish list"));

            }

        }else{
            echo json_encode(array("status" => "fail" , "message"=>"not logged"));

        }
    }else{
        echo json_encode(array("status" => "fail" , "message"=>"title param required"));
    }
}

?>

