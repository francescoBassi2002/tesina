<?php

require_once "../../config/db.php";

class Users{
    
    private static $table = 'users';
    private static $queryCount = 0;

    

    public static function logIn($username , $psw){
        self::$queryCount +=1;
        Db::query("SELECT * FROM users WHERE username = ? AND psw = ?" , [$username , $psw]);
        $res = Db::FetchOne();
        return $res;

    }

    public static function exist($username){
        self::$queryCount += 1;

        Db::query("SELECT * FROM users WHERE username = ?" , [$username]);
        $res = Db::FetchOne();

        if ($res){
            return true;
        }else{
            return false;
        }

    }

    public static function signUp($username , $psw , $name , $surname, $tel , $email , $money){
        self::$queryCount +=1;

        $params = [$username , $psw , $email , $name , $surname , $tel , 0 , $money];
        $res = Db::query("INSERT INTO users  (username , psw , email , name , surname, tel, admin, aviable_balance) VALUES (? , ? , ? , ? , ? , ? , ? , ?)" , $params);
        

        return $res;
    }

    public static function selectAll(){
        self::$queryCount +=1;  
        Db::query("SELECT * FROM users");
        return Db::FetchAll();

    }
    public static function getQueryCount(){
        return self::$queryCount;
    }
    
    public static function pay($username , $cost){
        self::$queryCount +=1;
        $usersTable = "users";
        
        $res = Db::query("UPDATE $usersTable SET aviable_balance = aviable_balance - ? WHERE username = ?" , [$cost , $username]);
        if(!$res){
            $out = "error";
        }else{
            if(intval(self::getCurrentBalance($username)) - $cost <0){
                $out = "no money";
            }else{
                $out = "success";
            }
        }
        return $out;
    }

    public static function getCurrentBalance($username){
        self::$queryCount += 1;
        Db::query("SELECT aviable_balance FROM users WHERE username = ?" , [$username]);
        $res = Db::FetchOne()["aviable_balance"];
        return $res;
    }

    public static function destroy($username){
        self::$queryCount += 1;
        $res = Db::query("DELETE FROM users WHERE username = ?" , [$username]);
        return $res;
    }

    public static function becomeAdmin($username){
        self::$queryCount += 1;
        $res = Db::query("UPDATE users SET admin = '1' WHERE username = ?" , [$username]);
        return $res;
    }

    public static function getAllPdf($username){
        self::$queryCount += 1;
        Db::query("SELECT pdf_src FROM tickets WHERE user = ?" , [$username]);
        $res = Db::FetchAll();
        return $res;
    }
}

?>