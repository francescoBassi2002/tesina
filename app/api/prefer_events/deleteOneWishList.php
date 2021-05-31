
<?php
require_once "../../models/prefEModel.php";
require_once "../../config/globals.php";
require_once "../../config/db.php";

//$conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
//$PreferEvents = new PreferEvents($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET"){
   
    
    if(key_exists("title" ,  $_GET)){
        session_start();

        $title = $_GET["title"];
        if($_SESSION && key_exists("username" , $_SESSION)){
            
            $res = PreferEvents::removeOneWishList($_SESSION["username"] , $title);
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
