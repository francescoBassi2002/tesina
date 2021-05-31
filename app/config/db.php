<?php 

require_once "globals.php";

class Db {   
    private static $pdo = null;
    private static $results;
    private static $query;
    private static $query_count = 0;
    private static $queryStr = '';
    private static $params;
    private static $host = "localhost";
    private static $name = "myticketone";
    private static $user = "root";
    private static $psw = "";

    public static function connect(){       
        $host = self::$host;
        $user = self::$user;
        $dbname = self::$name;
        $password = self::$psw;
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
        $pdo = new PDO($dsn , $user , $password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function query($sql, $params = array()){
        $pdo = self::connect();
        try{
            if ($pdo){
                self::$query = $pdo->prepare($sql);
                
                
                self::$query->execute($params); 
                
                    
                self::$query_count +=1;
                       
            }
            $pdo = null;
            return true;
        }catch(PDOException $e){
            echo ('pdo error: ' . $e->getMessage());
            return false;
        }
    }
    public static function FetchAll(){
        try{
            if (self::$queryStr == ''){
                return self::$query->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $sql = self::$queryStr;
                $params = self::$params;
                self::$queryStr = '';
                self::$params = null;
                return self::query($sql ,$params)::FetchAll();
            }
            self::$query_count +=1;
        }catch(PDOException $e){
            echo ('error: ' . $e->getMessage());
            return false;
        }
    }
    public static function FetchOne(){
        try{
            if (self::$queryStr == ''){
                return self::$query->fetch(PDO::FETCH_ASSOC);
            }else{
                $sql = self::$queryStr;
                $params = self::$params;
                self::$queryStr = '';
                self::$params = null;
                return self::query($sql ,$params)::FetchOne();
            }
            self::$query_count +=1;
        }catch(PDOException $e){
            echo ('error: ' . $e->getMessage());
            return false;
        }
    }
    public static function getQueryCount(){
        return self::$query_count;
    }
    
    public static function select($column){
        self::$queryStr .= "SELECT $column ";
    }
    public static function from($table){
        self::$queryStr = self::$queryStr."FROM $table ";
    }
    public static function where($cond){
        self::$queryStr = self::$queryStr."WHERE $cond ";
    }
    public static function params($params = array()){
        self::$params = $params;
    }
    public static function getQueryString(){
        return self::$queryStr;
    }

    public static function close(){
        self::$pdo = null;
    }

}





/*$database = new Db();

$User = new Users($database);


echo json_encode(Users::selectAll());

echo('count :' . $database->getQueryCount());
*/

/*
$res = $database->query("SELECT * FROM users")->FetchAll();
echo(json_encode($res));*/


?>