
<?php
require "../../models/eventModel.php";
require "../../config/globals.php";
require "../../config/db.php";

$conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
$Event = new Event($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET"){
   //TODO: RISOLVERE
    if(key_exists("es" , $_GET)){
        $es = ($_GET["es"] == "es1" || $_GET["es"] == "es2" || $_GET["es"] == "es3" ? $_GET["es"] : NULL);
        if ($es == NULL){
            $output = array("status" => "fail" , "message" => "invalid param value");
        }else{
            
            if($es == "es1"){
                $res = $Event->es1();
            }else if($es == "es2"){
                $res = $Event->es2();
            }else if($es == "es3"){
                $res = $Event->es3();
            }



            if($res){
                $output = array("status" => "success" , "data" => $res);
            }else{
                $output = array("status" => "fail" , "data" => $res);
            }
        }
    }else{
        $output = array("status" => "fail" , "message" => "param es required");
    }


   



}
echo json_encode($output);

?>
