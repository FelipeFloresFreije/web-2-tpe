<?php
    session_start();

    require_once './config.php';    
    require_once './app/controllers/noticiasController.php';
    require_once './app/controllers/seccionController.php';
    require_once './app/controllers/authController.php';
    require_once './app/middleware/sessionMiddleware.php';
    require_once './app/middleware/guardMiddleware.php';

    define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');


    // accion por defecto
    $action = 'home';

    if (!empty($_GET['action'])) {
        $action = $_GET['action'];
    }

    $params = explode('/', $action);
    $request = new stdClass();
    $request = (new sessionMiddleware())->run($request);

    switch($params[0]){
            case 'home':
                //llamo ambos getAll en categorias
                $sessionMiddleware = new SessionMiddleware();
                $request = $sessionMiddleware->run($request);
                $controller = new SeccionController();
                $controller->showSeccion($request);
                break;
            case 'mostrarSeccion':
                $controller = new SeccionController();
                $controller->mostrarSeccion($request);
                break;
            case 'eliminarSeccion':
                $request = (new GuardMiddleware())->run($request);
                $controller = new SeccionController();
                $request->id=  $_POST['id_categoria'];
                $controller->removeSeccion($request);
                break;
            case 'agregarSeccion':
                $request = (new GuardMiddleware())->run($request);
                $controller = new SeccionController();
                $controller->agregarSeccion($request);
                break;
            case'modificarSeccion':
                $request = (new GuardMiddleware())->run($request);
                $controller = new SeccionController();
                $request->id=  $_POST['id_categoria'];
                $controller->modificarSeccion($request);
                break;
            // AGREGAR
            /*case 'mostrarNoticia':
                $controller = new NoticiasController();
                $id = $params[1];
                $controller->mostrarNoticia($id);
                break;*/
            case 'eliminarNoticia':
                $controller = new NoticiasController();
                $id =  $_POST['id_categoria'];
                $controller->delete($id);
                break;
            case 'agregarNoticia':
                $request = (new GuardMiddleware())->run($request);
                $controller = new NoticiasController();
                $controller->add();
                break;
            case'modificarNoticia':
                $request = (new GuardMiddleware())->run($request);
                $controller = new NoticiasController();
                $request->id=  $_POST['id_categoria'];
                $controller->editar($request);
                break;
            case 'login':
                $controller = new AuthController();
                $controller->doLogin($request);
                break;
            case 'validate':
                $authController = new AuthController();
                $authController->doLogin($request);
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
                echo "404 Page Not Found";
    }
?>