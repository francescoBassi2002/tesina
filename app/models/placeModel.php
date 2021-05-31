<?php
require_once "../../config/db.php";

class Place{
    private static $db = null;
    private static $table = 'places';
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
    
    public static function getByTitle($title){
        self::$queryCount +=1;  
        Db::select('P.*, E.title');
        Db::from("places P, events E");
        Db::where("P.id = E.place_id AND E.title = ?");
        Db::params([$title]);
        $res = Db::FetchAll();

        return $res;

    }
    
}


?>