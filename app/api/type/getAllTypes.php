<?php
    require "../../models/typeModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";
    
    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $Type = new Type($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        $res = $Type->getAllType();
        echo json_encode(array("status" => "success" , "data" => $res));
    
    }else{
        echo json_encode(array("status" => "fail" , "message" => "invalid request method"));
    }

?>