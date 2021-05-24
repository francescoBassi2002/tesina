<?php
    $dbName = "myticketone";   
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPsw = ""; 
    $adminPsw = "password";
    


    require_once "dompdf/autoload.inc.php";
    require_once "vendor/autoload.php";

    use Dompdf\Dompdf;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader

    function preparePdf($fileName , $html, $username){
        

        $domPdf = new Dompdf();
        
        
        $domPdf->load_html($html);
        $domPdf->setPaper("A4" , "landscape");
        
        
        $domPdf->render();
        
        $file = $domPdf->output();
        
        
        $fp = fopen("../../pdf/". md5($username). "/" .$fileName , "a");

        fwrite($fp , $file);
        fclose($fp);

        //file_put_contents($fileName , $file, FILE_USE_INCLUDE_PATH);



        return "../../pdf/". md5($username). "/" .$fileName;
    }





    function sendMail($userFrom, $psw , $to , $subject , $body , $file){
        
        
        
        
        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
        
            $mail->Mailer = "smtp";
            //$mail->SMTPDebug = 1;                      //Enable verbose debug output
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $userFrom;                     //SMTP username
            $mail->Password   = $psw;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;      
        
            $mail->isHTML(true);                                  //Set email format to HTML
        
        
            //Recipients
            $mail->addAddress($to , 'bassi');
        
            $mail->setFrom($userFrom);
                        //Name is optional
            $mail->From = $userFrom;
        
        
            //Attachments
            $mail->addAttachment($file);         //Add attachments
                //Optional name
        
            //Content
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
        
    }

?>