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

    public function validate($request) {
        if (empty($_SESSION['USER_ID'])) {
            header('Location: login');
            exit();
        } else {
            header('Location: home');
            exit();
        }
    }

    public function doLogin($request) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->view->showLogin();
        }

        if (empty($_POST['email']) || empty($_POST['password'])) {
            return $this->view->showLogin("Faltan datos obligatorios");
        }

        $user = $_POST['email'];
        $password = $_POST['password'];

        $userFromDB = $this->userModel->getByUser($user);

        if($userFromDB && password_verify($password, $userFromDB->password)) {
            $_SESSION['USER_ID'] = $userFromDB->id_usuario;
            $_SESSION['USER_NAME'] = $userFromDB->email;
            $_SESSION['ROLE_USER'] = $userFromDB->rol;
            header('Location: ' . BASE_URL);
            die();
        } else {
            return $this->view->showLogin("Usuario o contraseña incorrecta");
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL);
        die();
    }

    public function registrar($request) {
        if(empty($_POST['email']) || empty($_POST['password'])) {
            return $this->view->showRegistrarse("Faltan datos obligatorios", $request->user);
        }
        $user = $_POST['email'];
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT) ;

        $id = $this->userModel->insert($user,$password);
        if ($id === false) {
            // Mandás el error a la vista como quieras
            echo("El email ya está en uso.");
            //header('Location: register');
            exit;
        }
        header('Location: ' . BASE_URL);
        die();
    }
}