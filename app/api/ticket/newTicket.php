
<?php
require "../../config/globals.php";
require "../../models/eventModel.php";

require "../../models/ticketModel.php";
require "../../models/userModel.php";
require "../../config/db.php";

$conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
$Ticket = new Ticket($conn);
$User = new Users($conn);
$Event = new Event($conn);
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if(key_exists("title" , $_GET) && key_exists("count" , $_GET)){
        $title = $_GET["title"];
        $count = intval($_GET["count"]);
        $cost = intval($Event->getCostByTitle($title));
        if($cost){
            $tot_cost = $count * $cost;
            session_start();
            if(isset($_SESSION) && key_exists("username" , $_SESSION)){
                $out = $User->pay($_SESSION["username"] , $tot_cost, $count);
    
    
                if($out == "success"){
                
                    $res = $Ticket->add($_SESSION["username"] , $title , $count);
                    if($res){
                        $current_balance = $User->getCurrentBalance($_SESSION["username"]);

                        $output = array("status" => "success" , "message" => "ticket buyed. Current balance: " . ( $current_balance? $current_balance : "no aviable"));
                    }else{
                        $output = array("status" => "fail" , "message" => "something went wrong");
                    }
                    
                }else{
                    $output = array("status" => "fail" , "message" => ($out == "no money" ? "no much money" : "payment went wrong") );
                }
        
            }else{
                $output = array("status" => "fail" , "message" => "not logged" );
    
            }
        }else{
            $output = array("status" => "fail" , "message" => "invalid title" );

        }

    }else{
        $output = array("status" => "fail" , "message" => "wrong params" );
    }
    
    echo json_encode($output);


}

?>

