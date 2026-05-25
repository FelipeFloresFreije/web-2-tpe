<?php

    class SessionMiddleware {
        
        public function run($request) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            if (isset($_SESSION['USER_ID'])) {
                $request->user = new stdClass();
                $request->user->id_usuario = $_SESSION['USER_ID'];
                $request->user->email = $_SESSION['USER_NAME'];
                $request->user->rol = $_SESSION['ROLE_USER'];
            } else {
                $request->user = null;
            }
            return $request;
        }
    }