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
        
    
        
    
        $res = $Event->getAll($genre , $type);
        
        echo json_encode($res);
    }else{
        $imgFolder = "../../image/ ";
        
        $title = $_POST["title"];
        $img = $_FILES["img_src"];
        $location = $_POST["location"];
        $date = $_POST["date"];
        $hour = $_POST["hour"];
        $ticket_price = $_POST["ticket_price"];
        $selt_tickets = 0;
        $artists = $_POST["artists"];
        $genre = $_POST["genre"];
        $type = $_POST["type"];
        $psw = $_POST["psw"];
        session_start();
        echo $_SESSION["username"] . "<br>";
        echo $psw . "<br>";
        $res = $User->logIn($_SESSION["username"] ,md5($psw) );
        if (!$res){
            
            
            header("location: ../../addEvent.html?message=password+doesnt+match");
        }

        $img_src = $img["name"];

        

        $destination = $imgFolder . $img_src;

        $imageFileType = strtolower(pathinfo($destination,PATHINFO_EXTENSION));

        echo $imageFileType;
        echo "<br>";

        $check = getimagesize($img["tmp_name"]);
        if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } else {
          header("location: ../../addEvent.html?message=File+is+not+an+image");
          
          $uploadOk = 0;
        }


        if (!in_array($imageFileType , $extensionAllowed)){
            header("location: ../../addEvent.html?message=extension+not+allowed");
        }


        move_uploaded_file($img["tmp_name"], $destination);

        
        
        if (!$Event->exist($title)){
            $res = $Event->create($title , $img_src , $location , $date , $hour , $ticket_price , $selt_tickets , $artists , $genre, $type);

            if ($res){
                $output = array("status" => "success" , "message" => "ok");
            }else{
                $output = array("status" => "fail" , "message" => "error");
            }

        }else{
            $output = array("status" => "fail" , "message" => "this event already exist") ;
            
        }
        header("location: ../../addEvent.html?message=" . $output["status"] . ":+" . $output["message"]);
        

    }
    

?>