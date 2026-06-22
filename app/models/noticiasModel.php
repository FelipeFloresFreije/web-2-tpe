<?php
require_once 'app/models/Model.php';
class NoticiasModel extends Model {

    public function getAll() {
        $query = $this->db->prepare('
            SELECT noticia.*, seccion.nombre AS nombre_seccion 
            FROM noticia 
            JOIN seccion ON noticia.id_seccion_fk = seccion.id_seccion
        ');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($id) {
        $query = $this->db->prepare('SELECT noticia.*, seccion.nombre AS nombre_seccion
                                    FROM noticia 
                                    JOIN seccion ON noticia.id_seccion_fk = seccion.id_seccion
                                    WHERE noticia.id_noticia = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insert($titulo, $cuerpo, $fecha, $id_seccion_fk) {
        $query = $this->db->prepare('INSERT INTO noticia(titulo, cuerpo, fecha, id_seccion_fk) VALUES(?,?,?,?)');
        $query->execute([$titulo, $cuerpo, $fecha, $id_seccion_fk]);

        // devuelve el ID de la noticia recién creada
        return $this->db->lastInsertId();
    }


    public function delete($id) {
        $query = $this->db->prepare('DELETE FROM noticia WHERE id_noticia = ?');
        $query->execute([$id]);
    }    
    
    public function editar($id, $titulo, $cuerpo, $fecha, $id_seccion_fk) {
        $query = $this->db->prepare('UPDATE noticia SET titulo = ?, cuerpo = ?, fecha = ?, id_seccion_fk = ? WHERE id_noticia = ?');
        $query->execute([$titulo, $cuerpo, $fecha, $id_seccion_fk, $id]);
    }

}