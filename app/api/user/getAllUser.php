<?php
    require_once "../../models/userModel.php";
    require_once "../../config/globals.php";
    require_once "../../config/db.php";

    $conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
    $User = new Users($conn);
    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        session_start();
        
        if (key_exists("username" , $_SESSION)){
            echo json_encode(array("status" => "success", "data" => Users::getAllPdf($_SESSION["username"])));
        }else{
            echo json_encode(array("status" => "fail" , "message" => "not logged"));
        }
    }

?>