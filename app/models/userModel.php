<?php

class Users{
    private $db = null;
    private $table = 'users';
    private $queryCount = 0;

    function __construct($db){
        $this->db = $db;
    }

    public function logIn($username , $psw){
        $this->queryCount +=1;

        $res = $this->db->select("*")->from($this->table)->where("username = ? AND psw = ?")->params([ $username , $psw])->FetchOne();

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