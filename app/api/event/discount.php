
<?php
require "../../models/eventModel.php";
require "../../config/globals.php";
require "../../config/db.php";

$conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
$Event = new Event($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET"){
   
    $title = (key_exists("title" , $_GET) ? strtolower($_GET["title"]): NULL);
    $percent = (key_exists("percent" , $_GET) ? $_GET["percent"] : NULL);
    if($title && $percent){

        if(intval($percent) > 0 && intval($percent) <= 100){
            $badEvents = $Event->getBadSuccess();
            $titles = array();
            foreach($badEvents as $event){
                array_push($titles , strtolower($event["title"]));
            }


            if(in_array($title , $titles) && $Event->getDiscount($title) == "0"){
                $res = $Event->discount($title, $percent);
    
    
    
                if(!$res){
                    $output = array("status" => "fail" , "message" => "something went wrong");
                }else{
                    $output = array("status" => "success" , "message" => "discount applyed");
    
                }
    
            }else{
                $output = array("status" => "fail" , "message" => "you can't apply a discount on this event");
    
            }
        }else{
            $output = array("status" => "fail" , "message" => "invalid percent");

        }

        

    }else{
        $output = array("status" => "fail" , "message" => "invalid params");

    }

    echo json_encode($output);
    
}

?>
