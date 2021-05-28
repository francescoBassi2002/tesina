<?php
    require "../../models/userModel.php";
    require "../../models/eventModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";
    
    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $User = new Users($conn);
    $Event = new Event($conn);
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["username"])){
            $username = $_POST["username"];

        }else if (key_exists("username" , $_SESSION)){
            $username = $_SESSION["username"];
        
        }else{
            die("username required");
        }
        $psw = md5($_POST["psw"]);
       

        if(key_exists("privacy_terms" , $_POST)){
            $res = $User->login($username , $psw);
            //print_r($res);
            
    
            
            if (!$res) {
                echo json_encode(array("status" => "fail" , "message" => "invalid credentials"));
            }else{
    
                if ($res["tel"]){
                    $_SESSION["tel"] = $res["tel"];
    
                }
    
                $_SESSION["username"] = $res["username"];
                $_SESSION["name"] = $res["name"];
                $_SESSION["surname"] = $res["surname"];
                $_SESSION["email"] = $res["email"];
                $_SESSION["admin"] = ($res["admin"] == 1 ? true : false);
                $_SESSION["psw"] = $res["psw"];

                $Event->deleteOldEvents();

                echo json_encode(array("status" => "success" , "message" => "ok"));
            }
            
        }else{
            echo json_encode(array("status" => "fail" , "message" => "You must accept privacy terms and conditions"));

        }
       
       
        
    }else{
        session_start();
        session_destroy();
        echo json_encode(array("status" => "success" , "message" => "session destroyed"));
    }

?>