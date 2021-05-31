
<?php
require_once "../../models/eventModel.php";
require_once "../../config/globals.php";
require_once "../../config/db.php";


$conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
$Event = new Event($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if(key_exists("title" , $_GET)){
        $title = $_GET["title"];

        $res = Event::getOne($title);
        $res["remain_tickets"] = Event::getRemanaintTickets($title);
        if($res){
            echo json_encode(array("status"=>"success" , "data"=>$res));
    
        }else{
            echo json_encode(array("status"=>"fail" , "message"=>"invalid title"));
        }
    }else{
            echo json_encode(array("status"=>"fail" , "message"=>"title required"));

    }
    

}

?>
