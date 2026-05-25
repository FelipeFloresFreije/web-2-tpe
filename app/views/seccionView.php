<?php

    class seccionView {

        public function renderIndex($noticias, $secciones, $user) {
            // Al requerir los archivos, las variables de arriba quedan disponibles automáticamente en los .phtml
            require_once './templates/header.phtml';
            require_once './templates/index.phtml';
            require_once './templates/footer.phtml';
        }
        
        public function showSeccion($seccion, $noticias=null, $user=null) {
            $count = count($seccion);
            // NOTA: el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion
            require_once './templates/index.phtml';
        }
        public function showError($error,$user) {
            echo "<h1>$error</h1>";
        }
    }