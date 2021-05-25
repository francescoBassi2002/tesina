<?php 
class PreferEvents{
    private $db;
    private $query_count;
    private $table = 'prefer_events';


    function __construct($db){
        $this->db = $db;
    }

    

    public function addWishList($title , $username,$case){
        $this->query_count +=1 ;
        $id = $this->db->query("SELECT id FROM events WHERE title = ?" , [$title])->FetchOne()["id"];

        //$table= ($case == 0? "prefer_events" : "like_events");

        if($case == 1 && $this->db->query("SELECT * FROM $this->table WHERE id_e = ? AND username = ?" , [$id,$username])->FetchOne()){
            $query = "DELETE FROM $this->table WHERE username = ? AND id_e = ? AND caso = ?";
        }else{
            $query = "INSERT INTO $this->table (username , id_e, caso) VALUES ( ? , ? , ?)";
        }

        $res = $this->db->query($query , [$username , $id, $case]);
        return $res;

    }

    public function getAllWishList($username){
        $this->query_count += 1;

        $res = $this->db->query("SELECT E.title FROM events E , $this->table P WHERE P.id_e = E.id AND username = ? AND caso = 0" , [$username])->FetchAll();

        return $res;

    }
    
    public function existLikeList($title , $username){
        $this->query_count += 1;
        $id = $this->db->query("SELECT id FROM events WHERE title = ?" , [$title])->FetchOne()["id"];

        return $this->db->query("SELECT * FROM $this->table WHERE id_e = ? AND username = ? AND caso = 1" , [$id,$username])->FetchOne();
    }

    public function removeOneWishList($username , $title){

        $this->query_count += 1;
       
        $id_e = $this->db->query("SELECT id FROM events WHERE title = ?" , [$title])->FetchOne()["id"];

        $res = $this->db->query("DELETE FROM $this->table WHERE id_e= ? AND username = ? AND caso = 0" , [$id_e,$username]);

        return $res;
    }



}








?>