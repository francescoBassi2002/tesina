<?php
    require "../../models/placeModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";

    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $Place = new Place($conn);
    if ($_SERVER["REQUEST_METHOD"] == "GET"){
            echo json_encode(array("status" => "success", "data" => $Place->selectAll()));
    }

?>