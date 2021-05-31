<?php

class Type{
    private static $db;
    private static $queryCount;
    private static $table = "events";

    
    public static function getAllType(){
        self::$queryCount +=1;

        Db::query("SELECT * FROM types");
        $res = Db::FetchAll();

        return $res;
    }

}

?>