<?php

    require "../../models/eventModel.php";
    require "../../models/userModel.php";
    require "../../config/globals.php";
    require "../../config/db.php";

    $conn = new db($dbHost , $dbUser , $dbPsw , $dbName);
    $Event = new Event($conn);
    $User = new Users($conn);
    $extensionAllowed = ["png" , "jpg" , "jpeg" , "gif"];

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        
        $genre = (array_key_exists("genre" , $_GET) ? $_GET["genre"] : NULL);
        $type = (array_key_exists("type" , $_GET) ? $_GET["type"] : NULL);
        $bad_success = (array_key_exists("bad_success" , $_GET) ? $_GET["bad_success"] : NULL);
        
    
        
    
        $res = $Event->getAll($genre , $type, $bad_success);
        /*
        for($a = 0; $a < count($res) ; $a += 1){
            unset($res[$a]["discounted"]);
        }*/


        echo json_encode($res);
    }else{
        $imgFolder = "../../image/";
        print_r($_POST);
        $title = $_POST["title"];
        $img = $_FILES["img_src"];
        $date = $_POST["date"];
        $hour = $_POST["hour"];
        $ticket_price = $_POST["ticket_price"];
        $artists = $_POST["artists"];
        $genre = $_POST["genre"];
        $type = $_POST["type"];
        $id_place = $_POST["id_place"];
        $psw = $_POST["psw"];
        $tot_tickets = $_POST["tot_tickets"];
        session_start();
        echo $id_place;
        /*
        echo $_SESSION["username"] . "<br>";
        echo $psw . "<br>";*/
        $res = $User->logIn($_SESSION["username"] ,md5($psw) );



        if(intval($tot_tickets)<50){
            header("location: ../../addEvent.html?message=at+least+50+tickets+please");
        }

        if (!$res){
            
            
            header("location: ../../addEvent.html?message=password+doesnt+match");
        }

    

        
        
        if (!$Event->exist($title)){

            $img_src = $img["name"];

        

            $destination = $imgFolder . $img_src;
    
            $imageFileType = strtolower(pathinfo($destination,PATHINFO_EXTENSION));
    /*
            echo $imageFileType;
            echo "<br>";*/
    
            $check = getimagesize($img["tmp_name"]);
            if($check !== false) {
              //echo "File is an image - " . $check["mime"] . ".";
              $uploadOk = 1;
            } else {
              header("location: ../../addEvent.html?message=File+is+not+an+image");
              
              $uploadOk = 0;
            }
    
    
            if (!in_array($imageFileType , $extensionAllowed)){
                header("location: ../../addEvent.html?message=extension+not+allowed");
            }
    
    
            move_uploaded_file($img["tmp_name"], trim($destination));

            $res = $Event->create($title , $img_src , $date , $hour , $ticket_price , $artists , $genre, $type , $tot_tickets, $id_place);

            if ($res){
                $output = array("status" => "success" , "message" => "ok");
            }else{
                $output = array("status" => "fail" , "message" => "error");
            }

        }else{
            $output = array("status" => "fail" , "message" => "this event already exist") ;
            
        }
        header("location: ../../addEvent.html?message=" . $output["status"] . ":+" . $output["message"]);
        //echo json_encode($output);

    }
    

?>