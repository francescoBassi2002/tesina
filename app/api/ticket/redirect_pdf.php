
<?php


if ($_SERVER["REQUEST_METHOD"] == "GET"){
    print_r($_GET);
    $pdf = isset($_GET["pdf"]) ? $_GET["pdf"] : NULL;

    $parsePdf = explode("_" , $pdf);
    $pdfUser = $parsePdf[1];
    if($pdf){
        session_start();
        if(key_exists("username" , $_SESSION) && $_SESSION && $_SESSION["username"] == $pdfUser){
        
            
            //echo "success";
            header("location: ../../pdf/".md5($pdfUser)."/".$pdf);
        }else{
            header("location: ../../userInfo.html?message=permission+denied!");
            //echo "not logged";
        }
    }else{
        header("location: ../../userInfo.html?message=invalid+params");
        //var_dump($pdf);
        //echo "not pdf given";
    }
    
    
}



?>

