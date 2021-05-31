<?php
    require_once "../../models/userModel.php";
    require_once "../../config/globals.php";
    require_once "../../config/db.php";

    $conn = new Db($dbHost , $dbUser , $dbPsw , $dbName);
    $User = new Users($conn);

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $psw = $_POST["psw"];
        $psw2 = $_POST["psw2"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $tel = ($_POST["tel"] ? $_POST["tel"] : NULL);
        $money = $_POST["money"];


        $cond = true;

        if(!$tel){
            $cond = true;
        }else{
            if(intval($tel) != 0){
                $cond = true;
            }else{
                $cond = false;
            }
        }
        

        if($cond && intval($money) !=0){
            if ($psw == $psw2){

                if (!Users::exist($username)){
                    Users::signUp($username , md5($psw) , $name , $surname ,$tel, $email , $money);
                    mkdir("../../pdf/".md5($username));
                    echo json_encode(array("status" => "success", "message" => "registred succesfully"));
                }else{
                    echo json_encode(array("status" => "fail", "message" => "this user already exist!"));
    
                }       
            }else{
                echo json_encode(array("status" => "fail", "message" => "password not equal"));
            }
        }else{
            echo json_encode(array("status" => "fail", "message" => "tel and/or money param invalid"));

        }
        
   
    }else{
        
        session_start();
        
        if (key_exists("username" , $_SESSION)){
            echo json_encode(array("status" => "success", "data" => Users::logIn($_SESSION["username"] , $_SESSION["psw"])));
        }else{
            echo json_encode(array("status" => "fail" , "message" => "not logged"));
        }
    }

?>