<?php

class Place{
    private $db = null;
    private $table = 'places';
    private $queryCount = 0;

    function __construct($db){
        $this->db = $db;
    }

    

    public function selectAll(){
        $this->queryCount +=1;  
        return $this->db->select('*')->from($this->table)->FetchAll();

    }
    public function getQueryCount(){
        return $this->queryCount;
    }
    
    public function getByTitle($title){
        $this->queryCount +=1;  
        $res = $this->db->select('P.*, E.title')->from("places P, events E")->where("P.id = E.place_id AND E.title = ?")->params([$title])->FetchAll();

        return $res;

    }
    
}


?>