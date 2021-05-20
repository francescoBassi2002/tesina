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

    public function signUp($username , $psw , $name , $surname, $tel , $email , $money){
        $this->queryCount +=1;

        $params = [$username , $psw , $email , $name , $surname , $tel , 0 , $money];
        $res = $this->db->query("INSERT INTO $this->table (username , psw , email , name , surname, tel, admin, aviable_balance) VALUES (? , ? , ? , ? , ? , ? , ? , ?)" , $params);
        

        return $res;
    }

    public function selectAll(){
        $this->queryCount +=1;  
        return $this->db->select('*')->from($this->table)->FetchAll();

    }
    public function getQueryCount(){
        return $this->queryCount;
    }
    
    public function pay($username , $cost){
        $this->queryCount +=1;
        $usersTable = "users";
        
        $res = $this->db->query("UPDATE $usersTable SET aviable_balance = aviable_balance - ? WHERE username = ?" , [$cost , $username]);
        if(!$res){
            $out = "error";
        }else{
            if(intval($this->getCurrentBalance($username)) - $cost <0){
                $out = "no money";
            }else{
                $out = "success";
            }
        }
        return $out;
    }

    public function getCurrentBalance($username){
        $this->queryCount += 1;
        $res = $this->db->query("SELECT aviable_balance FROM users WHERE username = ?" , [$username])->FetchOne()["aviable_balance"];
        return $res;
    }

    public function destroy($username){
        $this->queryCount += 1;
        $res = $this->db->query("DELETE FROM users WHERE username = ?" , [$username]);
        return $res;
    }

    public function becomeAdmin($username){
        $this->queryCount += 1;
        $res = $this->db->query("UPDATE users SET admin = '1' WHERE username = ?" , [$username]);
        return $res;
    }

    public function getAllPdf($username){
        $this->queryCount += 1;
        $res = $this->db->query("SELECT pdf_src FROM tickets WHERE user = ?" , [$username])->FetchAll();
        return $res;
    }
}

?>