<?php
    require_once "../../models/placeModel.php";
    require_once "../../config/globals.php";
    require_once "../../config/db.php";

    $conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
    $Place = new Place($conn);
    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        if(key_exists("title", $_GET)){
            $title = $_GET["title"];
            echo json_encode(array("status" => "success", "data" => Place::getByTitle($title)));

        }else{
            echo json_encode(array("status" => "fail", "message" => "title required"));

        }
    }

?>