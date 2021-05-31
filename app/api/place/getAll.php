<?php
    require_once "../../models/placeModel.php";
    require_once "../../config/globals.php";
    require_once "../../config/db.php";

    $conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
    $Place = new Place($conn);
    if ($_SERVER["REQUEST_METHOD"] == "GET"){
            echo json_encode(array("status" => "success", "data" => Place::selectAll()));
    }

?>