<?php
    require_once "../../models/genreModel.php";
    require_once "../../config/globals.php";
    require_once "../../config/db.php";
    
    $conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
    $Genre = new Genre($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        $res = Genre::selectAll();
        echo json_encode(array("status" => "success" , "data" => $res));
    
    }else{
        echo json_encode(array("status" => "fail" , "message" => "invalid request method"));
    }

?>