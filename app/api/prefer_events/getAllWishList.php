
<?php
require "../../models/eventModel.php";
require "../../config/globals.php";
require "../../config/db.php";

$conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
$Event = new Event($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET"){
   
    
    session_start();
    if($_SESSION && key_exists("username" , $_SESSION)){

        $res = $Event->getAllWishList($_SESSION["username"]);

        if ($res){
            echo json_encode(array("status" => "success" , "data"=>$res));
            
        }else{
            echo json_encode(array("status" => "fail" , "message"=>"empty"));

        }

    }else{
        
        echo json_encode(array("status" => "fail" , "message"=>"not logged"));

    }

}else{
   
    echo json_encode(array("status" => "fail" , "message"=>"invalid request method"));


    
}

?>