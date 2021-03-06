
<?php
require_once "../../config/globals.php";
require_once "../../models/eventModel.php";

require_once "../../models/ticketModel.php";
require_once "../../models/userModel.php";
require_once "../../config/db.php";

$conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
$Ticket = new Ticket($conn);
$User = new Users($conn);
$Event = new Event($conn);
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if(key_exists("title" , $_GET) && key_exists("count" , $_GET)){
        $title = $_GET["title"];
        $count = intval($_GET["count"]);
        $cost = intval(Event::getCostByTitle($title));
        if($cost){
            $tot_cost = $count * $cost;
            session_start();
            if(isset($_SESSION) && key_exists("username" , $_SESSION)){


                $current_tot_tickets = Event::getOne($title)["tot_tickets"];

                if( intval(Event::getRemanaintTickets($title)) - $count >= 0){


                    //Event::newTicket($title , $count);




                    $out = Users::pay($_SESSION["username"] , $tot_cost, $count);
    
    
                    if($out == "success"){
                    
                        $res = $Ticket->add($_SESSION["username"] , $title , $count);
                        if($res){
                            $current_balance = Users::getCurrentBalance($_SESSION["username"]);
    
                            $output = array("status" => "success" , "message" => "ticket buyed. Current balance: " . ( $current_balance? $current_balance : "no aviable"));
                        }else{
                            $output = array("status" => "fail" , "message" => "something went wrong, check your email");
                        }
                        
                    }else{
                        $output = array("status" => "fail" , "message" => ($out == "no money" ? "no much money" : "payment went wrong") );
                    }
            
                }else{
                    $output = array("status" => "fail" , "message" => "there are not enough tickets :(");

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

