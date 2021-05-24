
<?php
require "../../models/ticketModel.php";
require "../../models/userModel.php";
require "../../models/eventModel.php";
require "../../config/globals.php";
require "../../config/db.php";

$conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
$Ticket = new Ticket($conn);
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    session_start();
    if(key_exists("username" , $_SESSION) && $_SESSION){
        
        $user = $_SESSION["username"];
        $res = $Ticket->deleteFromUser($user);


        $fileList = scandir("../../pdf/" . md5($user));

        /*
            filelist {
                [0] -> ".",
                [1] -> "..",
                [2] -> "esempio",
                [...]
            }

        */

        for ($a = 2; $a<count($fileList) ;$a ++ ){
            unlink("../../pdf/". md5($user) . "/" . $fileList[$a]);
        }

        if($res){
            $output = array("status" => "success" , "message" => "successfull deleted");
        }else{
            $output = array("status" => "fail" , "message" => "this event has no sales");
        }
    }else{
        $output = array("status" => "fail" , "message" => "not logged");

    }
    
}

echo json_encode($output);

?>

