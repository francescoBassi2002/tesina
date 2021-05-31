<?php
require_once "../../config/db.php";

class Genre{
    //private $db = null;
    private static $table = 'genres';
    private static $queryCount = 0;

    
    

    public static function selectAll(){
        self::$queryCount +=1;  
        Db::select('*');
        Db::from(self::$table);
        return Db::FetchAll();

    }
    public static function getQueryCount(){
        return self::$queryCount;
    }
    
    public static function setGenrePrefer($username , $genre){
            
            Db::query("SELECT id FROM genres WHERE genre = ?" , [$genre]);
            $id = Db::FetchOne()["id"];
        
            return Db::query("INSERT INTO prefer_genres VALUES (?,?)" , [$username, $id]);
        

      
    }
    public static function getPreferences($username){
        self::$queryCount +=1;  

        $query = "SELECT 
                    COUNT(*), G.genre 
                FROM 
                    prefer_events P, events E, genres G 
                WHERE 
                    P.id_e = E.id AND 
                    E.id_genre = G.id AND 
                    P.casO = 1 AND
                    P.username = ? 
                GROUP BY 
                    G.genre 
                ORDER BY 
                    `COUNT(*)` DESC";
        Db::query($query , [$username]);
        $res = Db::FetchAll();
        return $res;
    }

}
?>