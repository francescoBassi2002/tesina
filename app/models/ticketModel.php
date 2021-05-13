 <?php

class Ticket{
    private $db;
    private $query_count;
    private $table = 'tickets';


    function __construct($db){
        $this->db = $db;
    }

    public function add($username, $title, $count){
        $Event = new Event($this->db);
        $not_error = true;
        $this->query_count += 1;

        $id_e = $this->db->query("SELECT id FROM events WHERE title = ?" , [$title])->FetchOne()["id"];

        $pdfName = "ticket_" . $username . "_" . $id_e . "_";

        //echo "count: " . $count . "<br>";
        

        for($a = 0; $a<$count; $a++){

            //TODO: CREATE PDF
            //how many pdf

            //pdf name: ticket_<username>_<event id>_<num of time that this user buyed tickets refered at this event (howManyPdf)>
            //echo($a);
            $howManyPdf = $this->db->query("SELECT COUNT(*) FROM $this->table WHERE user = ? AND id_e = ?" , [$username , $id_e])->FetchOne()["COUNT(*)"];
            $pdfName = $pdfName . $howManyPdf;

            $res = $this->db->query("INSERT INTO $this->table (pdf_src ,id_e , user, date) VALUES (? , ? , ? ,?)" , [$pdfName ,$id_e , $username , date("Y-m-d")]);

            $info =  $this->db->query("SELECT * FROM tickets, users WHERE tickets.user = users.username AND pdf_src = ?" , [$pdfName])->FetchOne();

            $cost = $Event->getCostByTitle($title);

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

            $receipt = preparePdf($pdfName . ".pdf" , $body);

            move_uploaded_file( $receipt ,"pdf/");
            //TODO: SISTEMARE IL FATTO CHE LI SALVA NEL POSTO SBAGLIATO

            sendMail("bacobas.f@gmail.com" , "bacobas1977" , $_SESSION["email"] , "Payment receipt" , "no-reply" , $receipt);

            if (!$res){
                $not_error = false;
                break;
            }
            $pdfName = "ticket_" . $username . "_" . $id_e . "_";
        }
        return $not_error;


    }

    public function howMany_date($title){
        $this->query_count +=1;

        $res = $this->db->query("SELECT COUNT(*), T.date FROM events E, tickets T 
            WHERE E.id = T.id_e 
            AND E.title =?
            GROUP BY T.date" , [$title])
        ->FetchAll();

        return $res;
    }

}

?>