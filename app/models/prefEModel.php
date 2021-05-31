<?php 
class PreferEvents{
    private static $db;
    private static $query_count;
    private static $table = 'prefer_events';



    

    public static function addWishList($title , $username,$case){
        self::$query_count +=1 ;
        Db::query("SELECT id FROM events WHERE title = ?" , [$title]);
        $id = Db::FetchOne()["id"];

        //$table= ($case == 0? "prefer_events" : "like_events");

        if($case == 1 && Db::query("SELECT * FROM ".self::$table." WHERE id_e = ? AND username = ?" , [$id,$username])::FetchOne()){
            $query = "DELETE FROM ".self::$table." WHERE username = ? AND id_e = ? AND caso = ?";
        }else{
            $query = "INSERT INTO ".self::$table." (username , id_e, caso) VALUES ( ? , ? , ?)";
        }

        $res = Db::query($query , [$username , $id, $case]);
        return $res;

    }

    public static function getAllWishList($username){
        self::$query_count += 1;

        Db::query("SELECT E.title FROM events E , ".self::$table." P WHERE P.id_e = E.id AND username = ? AND caso = 0" , [$username]);
        $res = Db::FetchAll();

        return $res;

    }
    
    public static function existLikeList($title , $username){
        self::$query_count += 1;
        Db::query("SELECT id FROM events WHERE title = ?" , [$title]);
        $id = Db::FetchOne()["id"];

        Db::query("SELECT * FROM ".self::$table." WHERE id_e = ? AND username = ? AND caso = 1" , [$id,$username]);
        return Db::FetchOne();
    }

    public static function removeOneWishList($username , $title){

        self::$query_count += 1;
       
        Db::query("SELECT id FROM events WHERE title = ?" , [$title]);
        $id_e = Db::FetchOne()["id"];

        $res = Db::query("DELETE FROM ".self::$table." WHERE id_e= ? AND username = ? AND caso = 0" , [$id_e,$username]);

        return $res;
    }



}








?>