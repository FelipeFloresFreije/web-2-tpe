<?php
    session_start();
    require_once './config.php';
    require_once './app/middleware/sessionMiddleware.php';
    require_once './app/controllers/authController.php';
    require_once './app/controllers/seccionController.php';  
    require_once './app/controllers/noticiasController.php';
    require_once './app/middleware/guardMiddleware.php';
    
    define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

    $action = 'home';

    if (!empty($_GET['action'])) {
        $action = $_GET['action'];
    }

    $params = explode('/', $action);
    $request = new stdClass();
    $request = (new SessionMiddleware())->run($request);
    
    switch($params[0]) {
        case 'home':
            $controller = new SeccionController();
            $controller->showSeccion($request);
            break;

        case 'mostrarSeccion':
            $controller = new SeccionController();
            if (!empty($params[1])) {
                $request->id = $params[1];
                $controller->mostrarSeccion($request);
            } else {
                header('Location: ' . BASE_URL . 'home');
                die();
            }
            break;
        
        case 'eliminarSeccion':
            $request = (new GuardMiddleware())->run($request);
            $controller = new SeccionController();
            if (!empty($params[1])) {
                $request->id = $params[1];
                $controller->removeSeccion($request);
            } else {
                header('Location: ' . BASE_URL . 'home');
                die();
            }
            break;
        
        case 'nueva-seccion':
            $request = (new GuardMiddleware())->run($request);
            $controller = new SeccionController();
            $controller->cargarFormularioSeccion($request);
            break;
        case 'agregarSeccion':
            $request = (new GuardMiddleware())->run($request);
            $controller = new SeccionController();
            $controller->agregarSeccion($request);
            break;
        case 'editarSeccion':
            if (!empty($params[1])) {
                $controller = new SeccionController();
                $controller->cargarFormularioEditarSeccion($params[1], $request);
            } else {
                header('Location: ' . BASE_URL . 'home');
                die();
            }
            break;
        case 'modificarSeccion':
            $controller = new SeccionController();
            $controller->modificarSeccion($request);
            break;

        case 'mostrarNoticia':
            $controller = new NoticiasController();
            if (!empty($params[1])) {
                $controller->show($params[1]);
            } else {
                header('Location: ' . BASE_URL . 'home');
                die();
            }
            break;

        case 'eliminarNoticia':
            $request = (new GuardMiddleware())->run($request);
            $controller = new NoticiasController();
            if (!empty($params[1])) {
                $id = $params[1];
                $controller->delete($id);
            } else {
                header('Location: ' . BASE_URL . 'home');
                die();
            }
            break;

        case 'agregarNoticia':
            $request = (new GuardMiddleware())->run($request);
            $controller = new NoticiasController();
            $controller->add();
            break;

        case 'modificar':
            $request = (new GuardMiddleware())->run($request);
            $controller = new NoticiasController();
            if (!empty($params[1])) {
                $id = $params[1];
                $controller->editar($id);
            } else {
                header('Location: ' . BASE_URL . 'home');
                die();
            }
            break;

        case 'modificarNoticia':
            $request = (new GuardMiddleware())->run($request);
            if (!empty($params[1])) {
                $controller = new NoticiasController();
                $controller->cargarFormularioEditar($params[1], $request->user);
            } else {
                header('Location: ' . BASE_URL . 'home');
                die();
            }
            break;

        case 'login':
            $controller = new AuthController();
            $controller->doLogin($request);
            break;

        case 'validate':
            $authController = new AuthController();
            $authController->validate($request);
            break;

        case 'register':
            $authController = new AuthController();
            $authController->registrar($request);
            break;

        case 'logout':
            $authController = new AuthController();
            $authController->logout();
            break;

        default: 
            header('Location: ' . BASE_URL . 'home');
            die();
    }
?>