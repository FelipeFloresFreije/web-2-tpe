<?php
// app/models/Model.php

class Model {
    protected $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=" . MYSQL_HOST . ";charset=utf8", 
            MYSQL_USER, 
            MYSQL_PASS
        );
        
        // Ejecuto el despliegue automático
        $this->deploy();
    }

    private function deploy() {
        //Creo la base de datos si no existe automáticamente
        $this->db->query("CREATE DATABASE IF NOT EXISTS " . MYSQL_DB);
        
        //Selecciono la base de datos para empezar a crear las tablas
        $this->db->query("USE " . MYSQL_DB);

        // Comprobar si ya existen tablas instaladas 
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        
        // Si está vacía (count == 0), creamos la estructura y cargamos los datos iniciales
        if (count($tables) == 0) {
            $sql = <<<END
            -- --------------------------------------------------------
            -- Estructura de la tabla `seccion`
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `seccion` (
              `id_seccion` int(11) NOT NULL AUTO_INCREMENT,
              `nombre` varchar(100) NOT NULL,
              `descripcion` text DEFAULT NULL,
              PRIMARY KEY (`id_seccion`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- --------------------------------------------------------
            -- Estructura de la tabla `noticia`
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `noticia` (
              `id_noticia` int(11) NOT NULL AUTO_INCREMENT,
              `titulo` varchar(200) NOT NULL,
              `cuerpo` text NOT NULL,
              `fecha` date NOT NULL,
              `id_seccion_fk` int(11) NOT NULL,
              PRIMARY KEY (`id_noticia`),
              KEY `id_seccion_fk` (`id_seccion_fk`),
              CONSTRAINT `fk_noticia_seccion` FOREIGN KEY (`id_seccion_fk`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- --------------------------------------------------------
            -- Estructura de la tabla `usuario`
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `usuario` (
              `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(100) NOT NULL,
              `password` varchar(255) NOT NULL,
              `rol` varchar(50) NOT NULL DEFAULT 'user',
              PRIMARY KEY (`id_usuario`),
              UNIQUE KEY `email` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- --------------------------------------------------------
            -- Datos iniciales obligatorios para la entrega
            -- Usuario solicitado: "webadmin" / Contraseña: "admin"
            -- --------------------------------------------------------
            INSERT INTO `usuario` (`email`, `password`, `rol`) VALUES 
            ('webadmin', '\$2y\$10\$mCg7Y3W7yG1wKExR4r6RbeJshE2o3WBlX7NExrL7gY9Y9k.h16P6S', 'admin'); 

            -- Datos de prueba para las secciones y noticias
            INSERT INTO `seccion` (`id_seccion`, `nombre`, `descripcion`) VALUES
            (1, 'Deportes', 'Sección con novedades del ámbito deportivo.'),
            (2, 'Tecnologia', 'Espacio sobre gadgets, software y ciencia.');

            INSERT INTO `noticia` (`id_noticia`, `titulo`, `cuerpo`, `fecha`, `id_seccion_fk`) VALUES
            (1, 'Gran victoria local', 'El equipo se impuso con autoridad en el último minuto.', '2026-06-21', 1),
            (2, 'Nueva IA presentada', 'Se anunció un modelo open-source revolucionario.', '2026-06-21', 2);
END;

            // Ejecutar todo el script SQL estructurado
            $this->db->exec($sql);
        }
    }
}