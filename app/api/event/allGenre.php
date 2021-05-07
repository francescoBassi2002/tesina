<?php
    require "../../models/genreModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";
    
    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $Genre = new Genre($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        $res = $Genre->selectAll();
        echo json_encode(array("status" => "success" , "data" => $res));
    
    }else{
        echo json_encode(array("status" => "fail" , "message" => "invalid request method"));
    }

?>