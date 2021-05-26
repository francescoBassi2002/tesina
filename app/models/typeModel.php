<?php

class Type{
    private $db;
    private $queryCount;
    private $table = "events";

    function __construct($db){
        $this->db = $db;
    }

    public function getAllType(){
        $this->queryCount +=1;

        $res = $this->db->query("SELECT * FROM types")->FetchAll();

        return $res;
    }

}

?>