<?php
    require_once "models/userModel.php";
    $res = Db::query("SELECT username FROM users WHERE username = 'bassi'")::Db::FetchOne()["username"];
    var_dump($res);
?>