
<?php
require "../../models/prefEModel.php";
require "../../config/globals.php";
require "../../config/db.php";

$conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
$PrefEv = new PreferEvents($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET"){
   
    
    if(key_exists("title" ,  $_GET)){
        session_start();

        $title = $_GET["title"];
        if($_SESSION && key_exists("username" , $_SESSION)){
            
            $res = $PrefEv->removeOneWishList($_SESSION["username"] , $title);
    
            if($res){
                echo json_encode(array("status" => "success" , "message"=>"element deleted"));    
            }else{
                echo json_encode(array("status" => "fail" , "message"=>"something went wrong"));
    
            }
    
        }else{
            
            echo json_encode(array("status" => "fail" , "message"=>"not logged"));
    
        }
    }else{
        echo json_encode(array("status" => "fail" , "message"=>"title required"));

    }
    

    
}

?>
