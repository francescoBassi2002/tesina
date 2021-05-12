<?php
    require "../../models/userModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";
    
    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $User = new Users($conn);

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["username"])){
            $username = $_POST["username"];

        }else if (key_exists("username" , $_SESSION)){
            session_start();
            $username = $_SESSION["username"];
        
        }else{
            die("username required");
        }
        $psw = md5($_POST["psw"]);
        
       
       
        $res = $User->login($username , $psw);
        //print_r($res);
        

        
        if (!$res) {
            echo json_encode(array("status" => "fail" , "message" => "invalid credentials"));
        }else{
            session_start();

            if ($res["tel"]){
                $_SESSION["tel"] = $res["tel"];

            }

            $_SESSION["username"] = $res["username"];
            $_SESSION["name"] = $res["name"];
            $_SESSION["surname"] = $res["surname"];
            $_SESSION["email"] = $res["email"];
            $_SESSION["admin"] = ($res["admin"] == 1 ? true : false);
            $_SESSION["psw"] = $res["psw"];
            echo json_encode(array("status" => "success" , "message" => "ok"));
        }
        
    }else{
        session_start();
        session_destroy();
        echo json_encode(array("status" => "success" , "message" => "session destroyed"));
    }

?>