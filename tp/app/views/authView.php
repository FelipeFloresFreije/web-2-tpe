<?php
class authView {
    public function showLogin($error = null) {
        require_once './templates/form_login.phtml';
    }
    public function showRegistrarse($error = null) {
        require_once './templates/form_registrarse.phtml';
    }
}