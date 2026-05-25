<?php
    session_start();
    require_once './config.php';
    require_once './app/middleware/sessionMiddleware.php';
    require_once './app/controllers/authController.php';
    require_once './app/controllers/seccionController.php';  
    require_once './app/controllers/noticiasController.php';
    require_once './app/middleware/guardMiddleware.php';
    
    define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');


    // accion por defecto
    $action = 'home';

    if (!empty($_GET['action'])) {
        $action = $_GET['action'];
    }

    $params = explode('/', $action);
    $request = new stdClass();
    $request = (new SessionMiddleware())->run($request);
    
    switch($params[0]) {
            case 'home':
                //llamo ambos getAll en categorias
                $sessionMiddleware = new SessionMiddleware();
                $request = $sessionMiddleware->run($request);
                $controller = new SeccionController();
                $controller->showSeccion($request);
            break;

            case 'mostrarSeccion':
                $controller = new SeccionController();
                if (!empty($params[1])) {
                    $request->id = $params[1];
                    $controller->mostrarSeccion($request);
                } else {
                    echo("Ha ingresado mal los parametros");
                }
                break;
            
            case 'eliminarSeccion':
                $request = (new GuardMiddleware())->run($request);
                $controller = new SeccionController();
                if (!empty($params[1])) {
                    $request->id = $params[1];
                    $controller->removeSeccion($request);
                } else {
                    echo("Ha ingresado mal los parametros");
                }
                break;
            
            case 'agregarSeccion':
                $request = (new GuardMiddleware())->run($request);
                $controller = new SeccionController();
                $controller->agregarSeccion($request);
                break;
            
            case 'modificarSeccion':
                $request = (new GuardMiddleware())->run($request);
                $controller = new SeccionController();
                $controller->modificarSeccion($request);
                break;

            case 'mostrarNoticia':
                $controller = new NoticiasController();
                if (!empty($params[1])) {
                    $controller->show($params[1]);
                } else {
                    echo("Ha ingresado mal los parametros");
                }
                break;

            case 'eliminarNoticia':
                $request = (new GuardMiddleware())->run($request);
                $controller = new NoticiasController();
                if (!empty($params[1])) {
                    $id = $params[1];
                    $controller->delete($id);
                } else {
                    echo("Ha ingresado mal los parametros");
                }
                break;

            case 'agregarNoticia':
                $request = (new GuardMiddleware())->run($request);
                $controller = new NoticiasController();
                $controller->add();
                break;

            case 'modificar':
                $request = (new GuardMiddleware())->run($request);
                //chequea que este logueado, si no lo manda al login
                $controller = new NoticiasController();
                if (!empty($params[1])) {
                    $id = $params[1];
                    $controller->editar($id);
                } else {
                    echo("Ha ingresado mal los parametros");
                }
                break;

            case'modificarNoticia':
                $request = (new GuardMiddleware())->run($request);
                //chequea que este logueado, si no lo manda al login
                if (!empty($params[1])) {
                    $controller = new SeccionModel();
                    $secciones = $controller->getAll();
                    $user = $request->user;
                    $id_editar = $params[1];
                    include './templates/form_modificar.phtml';
                } else {
                    echo("Ha ingresado mal los parametros");
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
                echo "404 Page Not Found";
    }
?>