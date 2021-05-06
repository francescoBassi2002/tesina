<?php

class Users{
    private static $db = null;
    private static $table = 'users';
    private static $queryCount = 0;

    static function __constructStatic($db){
        self::$db = $db;
    }

    public static function logIn($username , $psw){
        self::$queryCount +=1;

        $res = self::$db->select("*")->from(self::$table)->where("username = ? AND psw = ?")->params([ $username , $psw])->FetchOne();

        return $res;

    }

    public function exist($username){
        $this->queryCount += 1;

        $res = $this->db->select("*")->from($this->table)->where("username = ?")->params([$username])->FetchOne();

        if ($res){
            return true;
        }else{
            return false;
        }

    }

    public function signUp($username , $psw , $name , $surname, $tel , $email){
        $this->queryCount +=1;

        $params = [$username , $psw , $email , $name , $surname , $tel , 0];
        $res = $this->db->query("INSERT INTO $this->table (username , psw , email , name , surname, tel, admin) VALUES (? , ? , ? , ? , ? , ? , ?)" , $params);
        

        return $res;
    }

    public function selectAll(){
        $this->queryCount +=1;  
        return $this->db->select('*')->from($this->table)->FetchAll();

    }
    public function getQueryCount(){
        return $this->queryCount;
    }
    

}

?>