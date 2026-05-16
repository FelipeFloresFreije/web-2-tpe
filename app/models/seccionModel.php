<?php

    class seccionModel{
        private $db;
        function __construct(){
            $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);                
        }
        public function getAll() {
                    
            $query = $this->db->prepare('SELECT * FROM seccion ORDER BY orden ASC');
            $query->execute();
            $seccion = $query->fetchAll(PDO::FETCH_OBJ);

            return $seccion;
        }
        public function get($id) {
        
            $query = $this->db->prepare('SELECT * FROM seccion WHERE id_seccion = ?');
            $query->execute([$id]);
            $task = $query->fetch(PDO::FETCH_OBJ);

            return $task;
        }
        function remove($id) {
            $query = $this->db->prepare('DELETE from seccion where id_seccion = ?');
            $query->execute([$id]);
        }
        function insert($descripcion, $nombre) {
            $query = $this->db->prepare("INSERT INTO seccion(descripcion, nombre) VALUES(?,?)");
            $query->execute([$descripcion, $nombre]);

            return $this->db->lastInsertId();
        }
        function modificar($id, $descripcion, $nombre) {
            $query = $this->db->prepare('UPDATE seccion SET descripcion = ? , nombre = ? WHERE id_seccion = ?');
            $query->execute([$descripcion, $nombre, $id]);
        }
    }