
<?php
require "../../models/ticketModel.php";
require "../../models/userModel.php";
require "../../models/eventModel.php";
require "../../config/globals.php";
require "../../config/db.php";

$conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
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

