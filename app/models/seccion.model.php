<?php

class SeccionModel {
    private $db;

    public function __construct() {
        // 1. abre conexión con DB
        $this->db = new PDO('mysql:host=localhost;dbname=tpe;charset=utf8', 'root', '');
    }


    public function getAll() {
        $query = $this->db->prepare('SELECT id_seccion, nombre FROM seccion');
        $query->execute();
        return $query->fetchAll();
    }
}