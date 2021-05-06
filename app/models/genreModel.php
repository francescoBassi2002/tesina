<?php

class Genre{
    private $db = null;
    private $table = 'genres';
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
    
    public function setGenrePrefer($username , $genre){
            
            $id = $this->db->query("SELECT id FROM genres WHERE genre = ?" , [$genre])->FetchOne()["id"];
        
            return $this->db->query("INSERT INTO prefer_genres VALUES (?,?)" , [$username, $id]);
        

      
    }
    public function reset($username){
        $this->db->query("DELETE FROM prefer_genres WHERE username = ?" , [$username]);
    }

}
?>