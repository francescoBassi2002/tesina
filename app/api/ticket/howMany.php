
<?php
require_once "../../models/ticketModel.php";
require_once "../../models/userModel.php";
require_once "../../models/eventModel.php";
require_once "../../config/globals.php";
require_once "../../config/db.php";

$conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
$Ticket = new Ticket($conn);
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if(key_exists("title" , $_GET)){
        
        $title = $_GET["title"];
        $res = $Ticket->howMany_date($title);

        if($res){
            $output = array("status" => "success" , "data" => $res);
        }else{
            $output = array("status" => "fail" , "message" => "this event has no sales");
        }
    }
    
}

echo json_encode($output);

?>

