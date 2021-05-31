<?php
    require_once "../../models/typeModel.php";
    require_once "../../config/globals.php";
    require_once "../../config/db.php";
    
    $conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
    $Type = new Type($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        $res = Type::getAllType();
        echo json_encode(array("status" => "success" , "data" => $res));
    
    }else{
        echo json_encode(array("status" => "fail" , "message" => "invalid request method"));
    }

?>