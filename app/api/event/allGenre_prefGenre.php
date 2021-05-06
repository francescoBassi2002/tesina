<?php
    require "../../models/genreModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";
    
    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $Genre = new Genre($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        $res = $Genre->selectAll();
        echo json_encode(array("status" => "success" , "data" => $res));
    }else if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $genres = $_POST["genre"];
        session_start();
        $Genre->reset($_SESSION["username"]);
        foreach ($genres as $genre){
            
            $Genre->setGenrePrefer($_SESSION["username"] , $genre);
        }
        echo json_encode(array("status" => "success" , "message" => "succesfuly sended preferces"));
    }else{
        echo json_encode(array("status" => "fail" , "message" => "invalid request method"));
    }

?>