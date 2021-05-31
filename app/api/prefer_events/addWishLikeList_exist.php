
<?php
require_once "../../models/prefEModel.php";
require_once "../../config/globals.php";
require_once "../../config/db.php";

$conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
//$PreferEvents = new PreferEvents($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if(key_exists("title" , $_GET) && key_exists("case" , $_GET)){
            $case = $_GET["case"];
            $title = $_GET["title"];

            session_start();
            if($_SESSION && key_exists("username" , $_SESSION)){
    
                $res = PreferEvents::addWishList($title , $_SESSION["username"] , $case);
    
                if ($res){
                    echo json_encode(array("status" => "success" , "message"=>($case == 0?"added succesfully at the wish list" : "nice choose!")));
                    
                }else{
                    echo json_encode(array("status" => "fail" , "message"=>($case == 0 ?"something went wrong. Maybe you already have this event in you wish list" : "something went wrong to put like")));
    
                }
    
            }else{
                echo json_encode(array("status" => "fail" , "message"=>"not logged"));
    
            }
        
    }else if(key_exists("title", $_GET) && count($_GET) == 1){
        $title = $_GET["title"];
        session_start();
            if($_SESSION && key_exists("username" , $_SESSION)){
                
                $res = PreferEvents::existLikeList($title , $_SESSION["username"]);
    
                if ($res){
                    echo json_encode(array("status" => "success" , "message"=>"exist"));

                }else{
                    echo json_encode(array("status" => "success" , "message"=>"not exist"));

                }
    
            }else{
                echo json_encode(array("status" => "fail" , "message"=>"not logged"));
    
            }

    }else{
        echo json_encode(array("status" => "success" , "message"=>"wrong params"));
        
    }
}

?>

