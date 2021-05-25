<?php
    require "../../models/genreModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";
    
    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $Genre = new Genre($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        session_start();
        if($_SESSION && key_exists("username" , $_SESSION)){
            $user = $_SESSION["username"];
            $res = $Genre->getPreferences($user);
            echo json_encode(array("status" => "success" , "data" => $res));
        }else{
            echo json_encode(array("status" => "fail" , "message" => "not logged"));

        }
        
    
    }else{
        echo json_encode(array("status" => "fail" , "message" => "invalid request method"));
    }
    /*

    $conn = new PDO("mysql:host=<nome host>;dbname:<nome del db" , "<utente>" , "<password>");

    $query = $conn->prepare("SELECT * FROM <TABELLA>");

    $query->execute(["<EVENTUALE ARRAY DI PARAMETRI, IN QUESTO CASO NON CI SONO>"]);

    $elenco_record = $query->fetchAll(PDO::FETCH_ASSOC);

    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);

    $res = $conn->query("SELECT * FROM <TABELLA>" , ["<EVENTUALE ARRAY PARAMETRI>"])->FetchAll();*/



?>