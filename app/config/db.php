<?php 
class db {   
    private $pdo = null;
    private $results;
    private $query;
    private $query_count = 0;
    private $queryStr = '';
    private $params;

    function __construct($host = 'localhost', $user = 'root', $passowrd = ''  , $dbname = 'test'){       
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
        $this->pdo = new PDO($dsn , $user , $passowrd);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function query($sql, $params = array()){
        try{
            if ($this->pdo){
                $this->query = $this->pdo->prepare($sql);
                
                
                $this->query->execute($params); 
                
                    
                $this->query_count +=1;
                return $this;               
            }
        }catch(PDOException $e){
            echo ('pdo error: ' . $e->getMessage());
            return false;
        }
    }
    public function FetchAll(){
        try{
            if ($this->queryStr == ''){
                return $this->query->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $sql = $this->queryStr;
                $params = $this->params;
                $this->queryStr = '';
                $this->params = null;
                return $this->query($sql ,$params)->FetchAll();
            }
            $this->query_count +=1;
        }catch(PDOException $e){
            echo ('error: ' . $e->getMessage());
            return false;
        }
    }
    public function FetchOne(){
        try{
            if ($this->queryStr == ''){
                return $this->query->fetch(PDO::FETCH_ASSOC);
            }else{
                $sql = $this->queryStr;
                $params = $this->params;
                $this->queryStr = '';
                $this->params = null;
                return $this->query($sql ,$params)->FetchOne();
            }
            $this->query_count +=1;
        }catch(PDOException $e){
            echo ('error: ' . $e->getMessage());
            return false;
        }
    }
    public function getQueryCount(){
        return $this->query_count;
    }
    
    public function select($column){
        $this->queryStr = $this->queryStr."SELECT $column ";
        return $this;
    }
    public function from($table){
        $this->queryStr = $this->queryStr."FROM $table ";
        return $this;
    }
    public function where($cond){
        $this->queryStr = $this->queryStr."WHERE $cond ";
        return $this;
    }
    public function params($params = array()){
        $this->params = $params;
        return $this;
    }
    public function getQueryString(){
        return $this->queryStr;
    }

    public function close(){
        $this->pdo = null;
    }

}





/*$database = new db();

$User = new Users($database);


echo json_encode($User->selectAll());

echo('count :' . $database->getQueryCount());
*/

/*
$res = $database->query("SELECT * FROM users")->FetchAll();
echo(json_encode($res));*/


?>