<?php

class userModel {
    private $db;

    function __construct() {
        // 1. abro conexión con la DB
        $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);                
    }
    /*
    public function get($id) {
        $query = $this->db->prepare('SELECT * FROM usuario WHERE id = ?');
        $query->execute([$id]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }*/

    public function getByUser($user) {
        $query = $this->db->prepare('SELECT * FROM usuario WHERE email = ?');
        $query->execute([$user]);   
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }
    /*
    public function getAll() {
        $query = $this->db->prepare('SELECT * FROM usuario');
        $query->execute();

        $users = $query->fetchAll(PDO::FETCH_OBJ);

        return $users;
    }
    */
    function insert($name, $password) {
        $query = $this->db->prepare("INSERT INTO usuario(email, password) VALUES(?,?)");
        $query->execute([$name, $password]);

        return $this->db->lastInsertId();
    }
}