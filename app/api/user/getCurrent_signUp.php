<?php
    require "../../models/userModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";

    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $User = new Users($conn);

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $psw = $_POST["psw"];
        $psw2 = $_POST["psw2"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $tel = ($_POST["tel"] ? $_POST["tel"] : NULL);
        

        if ($psw == $psw2){

            if (!$User->exist($username)){
                $User->signUp($username , md5($psw) , $name , $surname ,$tel, $email);
                echo json_encode(array("status" => "success", "message" => "registred succesfully"));
            }else{
                echo json_encode(array("status" => "fail", "message" => "this user already exist!"));

            }       
        }else{
            echo json_encode(array("status" => "fail", "message" => "password not equal"));
        }
   
    }else{
        
        session_start();
        
        if (key_exists("username" , $_SESSION)){
            echo json_encode(array("status" => "success", "data" => $User->logIn($_SESSION["username"] , $_SESSION["psw"])));
        }else{
            echo json_encode(array("status" => "fail" , "message" => "not logged"));
        }
    }

?>