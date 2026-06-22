<?php
    class seccionView {

        public function renderIndex($noticias, $secciones, $user) {
            require_once './templates/header.phtml';
            require_once './templates/index.phtml';
            require_once './templates/footer.phtml';
        }

        public function showSeccion($seccion, $secciones, $noticias, $user) {
            require_once 'templates/header.phtml';
            require_once 'templates/seccion.phtml';
            require_once 'templates/footer.phtml';
        }

        public function renderFormEditarSeccion($seccion, $user) {
            // Aseguramos que si $user no llegó del controlador, se intente rescatar de la sesión
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!$user && isset($_SESSION['USER_EMAIL'])) {
                $user = (object)[
                    'email' => $_SESSION['USER_EMAIL'],
                    'rol' => isset($_SESSION['USER_ROLE']) ? $_SESSION['USER_ROLE'] : (isset($_SESSION['ROLE']) ? $_SESSION['ROLE'] : 'admin')
                ];
            }

            // Al requerirlos acá, $seccion y $user van a estar disponibles sí o sí en la plantilla
            require_once './templates/header.phtml';
            require_once './templates/form_editar_seccion.phtml';
            require_once './templates/footer.phtml';
        }

        public function showError($error, $user) {
            echo "<h1>$error</h1>";
        }

        public function renderFormSeccion($user = null) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!$user && isset($_SESSION['USER_EMAIL'])) {
                $user = (object)[
                    'email' => $_SESSION['USER_EMAIL'],
                    'rol' => isset($_SESSION['USER_ROLE']) ? $_SESSION['USER_ROLE'] : (isset($_SESSION['ROLE']) ? $_SESSION['ROLE'] : 'admin')
                ];
            }
            require_once './templates/header.phtml';
            require_once './templates/form_seccion.phtml';
            require_once './templates/footer.phtml';
        }
    }