 <?php

class Ticket{
    private $db;
    private $query_count;
    private $table = 'tickets';


    function __construct($db){
        $this->db = $db;
    }

    public function add($username, $title, $count){
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