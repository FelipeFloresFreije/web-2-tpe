<?php
class authView {
    public function showLogin($error = null) {
        require_once './templates/form_login.phtml';
    }
}