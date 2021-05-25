<?php
    require "../../models/eventModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";
    
    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $Event = new Event($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        $res = $Event->getAllType();
        echo json_encode(array("status" => "success" , "data" => $res));
    
    }else{
        echo json_encode(array("status" => "fail" , "message" => "invalid request method"));
    }

?>