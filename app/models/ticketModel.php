 <?php
class Ticket{

    private static $db;
    private static $query_count;
    private static $table = 'tickets';


   

    public static function add($username, $title, $count){
        
        $mailPsw = "ciaociao1!";
        //Event = new Event(Db);
        $not_error = true;
        static::$query_count += 1;

        Db::query("SELECT id FROM events WHERE title = ?" , [$title]);
        $id_e = Db::FetchOne()["id"];

        $pdfName = "ticket_" . $username . "_" . $id_e . "_";

        //echo "count: " . $count . "<br>";
        

        for($a = 0; $a<$count; $a++){

            //TODO: CREATE PDF
            //how many pdf

            //pdf name: ticket_<username>_<event id>_<num of time that this user buyed tickets refered at this event (howManyPdf)>
            //echo($a);
            Db::query("SELECT COUNT(*) FROM ".static::$table." WHERE user = ? AND id_e = ?" , [$username , $id_e]);
            $howManyPdf = Db::FetchOne()["COUNT(*)"];
            $pdfName = $pdfName . $howManyPdf;

            $res = Db::query("INSERT INTO ".static::$table." (pdf_src ,id_e , user, date) VALUES (? , ? , ? ,?)" , [$pdfName ,$id_e , $username , date("Y-m-d")]);

            Db::query("SELECT * FROM tickets, users WHERE tickets.user = users.username AND pdf_src = ?" , [$pdfName]);
            $info = Db::FetchOne();

            $cost = Event::getCostByTitle($title);

            $body = "
                

                <h1>You receipt: %name% %surname%</h1>
                <h3>Thanks for your choice!</h3>
                <h3>Id ticket %id% (md5 hash for security)</h3>
                <p>Prenoted event: %title% <br> 
                Total price: %tot_price%
                Date: %date%

                </p>
            ";

            $body = str_replace("%id%" , md5($info["id"]) , $body);
            $body = str_replace("%name%" , $info["name"] , $body);
            $body = str_replace("%surname%" , $info["surname"] , $body);
            $body = str_replace("%title%" , $title , $body);
            $body = str_replace("%tot_price%" , $cost , $body);
            $body = str_replace("%date%" , $info["date"] , $body);

            $receipt = preparePdf($pdfName . ".pdf" , $body, $username);

            $email_val = sendMail("tesina.bassi@gmail.com" , $mailPsw , $_SESSION["email"] , "Payment receipt" , "no-reply" , $receipt);

            if (!$res || !$email_val){
                $not_error = false;
                break;
            }
            $pdfName = "ticket_" . $username . "_" . $id_e . "_";
        }
        return $not_error;


    }

    public static function howMany_date($title){
        static::$query_count +=1;

        Db::query("SELECT COUNT(*), T.date FROM events E, tickets T 
            WHERE E.id = T.id_e 
            AND E.title =?
            GROUP BY T.date" , [$title]);
        $res = Db::FetchAll();

        return $res;
    }

    public static function howMany_title($title){
        static::$query_count +=1;

        Db::query("SELECT id FROM events WHERE title = ?" , [$title]);
        $id_e = Db::FetchOne()["id"];

        Db::query("SELECT COUNT(*) FROM tickets WHERE id_e = ?" , [$id_e]);
        $res = Db::FetchOne()["COUNT(*)"];
        

        return $res;
    }

    public static function deleteFromUser($user){
        static::$query_count +=1;
        $res = Db::query("DELETE FROM tickets WHERE user = ?" , [$user]);
        return $res;
    }


}

?>