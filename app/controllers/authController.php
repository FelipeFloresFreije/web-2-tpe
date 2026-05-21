<?php
require_once './app/models/userModel.php';
require_once './app/views/authView.php';

class AuthController {
    private $userModel;
    private $view;

    function __construct() {
        $this->userModel = new userModel();
        $this->view = new authView();
    }

    public function showLogin() {
        $this->view->showLogin();
    }

    public function doLogin($request) {
        if(empty($_POST['usuario']) || empty($_POST['password'])) {
            return $this->view->showLogin("Faltan datos obligatorios", $request->user);
        }

        $user = $_POST['usuario'];
        $password = $_POST['password'];

        $userFromDB = $this->userModel->getByUser($user);

        if($userFromDB && password_verify($password, $userFromDB->password)) {
            $_SESSION['USER_ID'] = $userFromDB->id;
            $_SESSION['USER_NAME'] = $userFromDB->usuario;
            $_SESSION['ROLE_USER'] = $userFromDB->rol;
            header('Location: ' . BASE_URL);
            die();
        } else {
            return $this->view->showLogin("Usuario o contraseña incorrecta", $request->user);
        }
    }
    public function registrar($request) {
        if(empty($_POST['usuario']) || empty($_POST['password'])) {
            return $this->view->showLogin("Faltan datos obligatorios", $request->user);
        }
        $user = $_POST['usuario'];
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT) ;

        $this->userModel->insert($user,$password);
        header('Location: ' . BASE_URL);
        die();
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL);
        die();
    }
}