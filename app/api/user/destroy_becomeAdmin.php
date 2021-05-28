<?php
    require "../../models/userModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";

    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $User = new Users($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        
        session_start();
        
        
        if (key_exists("username" , $_SESSION)){
            $user = $_SESSION["username"];
            $tables = ["prefer_events" , "prefer_genres" , "tickets"];
            foreach($tables as $table){
                $deltable = $conn->query("DELETE FROM $table WHERE ". ($table != "tickets" ? "username" : "user"). "=?" , [$user]);
                if(!$deltable){
                    break;
                }
            }

            if($deltable){
                $res = $User->destroy($user);

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
                rmdir("../../pdf/". md5($user));

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
    }else if($_SERVER["REQUEST_METHOD"] == "POST"){
        $psw = (key_exists("psw" , $_POST) ? $_POST["psw"]: NULL );
        if($psw){
            session_start();
            if (key_exists("username" , $_SESSION)){
                if($psw == $adminPsw){
                    $res = $User->becomeAdmin($_SESSION["username"]);
                    if($res){
                        header("location: ../../userPage.php?message=successful+became+admin");
                    }else{
                        header("location: ../../userPage.php?message=something+went+wrong");

                    }
                }else{
                    header("location: ../../userPage.php?message=invalid+psw");
                }
            }else{
                header("location: ../../userPage.php?message  =not+logged");
            }

        }else{
            header("location: ../../userPage.php?message=psw+param+required");
            

        }
    }
    

?>