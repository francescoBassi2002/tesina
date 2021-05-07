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
    public function getPreferences($username){
        $this->queryCount +=1;  

        $query = "SELECT COUNT(*), G.genre FROM like_events L, events E, genres G WHERE L.id_e = E.id AND E.id_genre = G.id AND L.username = ? GROUP BY G.genre ORDER BY `COUNT(*)` DESC";
        $res = $this->db->query($query , [$username])->FetchAll();
        return $res;
    }

}
?>