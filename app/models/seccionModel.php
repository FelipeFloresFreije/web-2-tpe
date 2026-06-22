<?php
require_once 'app/models/Model.php';
    class seccionModel extends Model {
        public function getAll() {
                    
            $query = $this->db->prepare('SELECT * FROM seccion ORDER BY id_seccion ASC');
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