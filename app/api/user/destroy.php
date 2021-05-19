<?php
    require "../../models/userModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";

    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $User = new Users($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        
        session_start();
        
        
        if (key_exists("username" , $_SESSION)){

            $tables = ["like_events" , "prefer_events" , "prefer_genres" , "tickets"];
            foreach($tables as $table){
                $deltable = $conn->query("DELETE FROM $table WHERE ". ($table != "tickets" ? "username" : "user"). "=?" , [$_SESSION["username"]]);
                if(!$deltable){
                    break;
                }
            }

            if($deltable){
                $res = $User->destroy($_SESSION["username"]);
                if($res){
                    echo json_encode(array("status" => "success", "message" => "ok"));
    
                }else{
                    echo json_encode(array("status" => "fail", "message" => "something went wrong"));
    
                }
            }else{
                echo json_encode(array("status" => "fail", "message" => "something went wrong1"));

            }

            
        }else{
            echo json_encode(array("status" => "fail" , "message" => "not logged"));
        }
    }
    

?>