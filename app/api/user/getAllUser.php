<?php
    require "../../models/userModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";

    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $User = new Users($conn);
    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        session_start();
        
        if (key_exists("username" , $_SESSION)){
            echo json_encode(array("status" => "success", "data" => $User->getAllPdf($_SESSION["username"])));
        }else{
            echo json_encode(array("status" => "fail" , "message" => "not logged"));
        }
    }

?>