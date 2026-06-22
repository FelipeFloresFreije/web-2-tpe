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
    $request->id = !empty($params[1]) ? $params[1] : null;
    
    $request = (new SessionMiddleware())->run($request);
    
    switch($params[0]) {
        case 'home':
            (new SeccionController())->showSeccion($request);
            break;

        case 'mostrarSeccion':
            (new SeccionController())->mostrarSeccion($request);
            break;
        
        case 'eliminarSeccion':
            $request = (new GuardMiddleware())->run($request);
            (new SeccionController())->removeSeccion($request);
            break;
        
        case 'nueva-seccion':
            $request = (new GuardMiddleware())->run($request);
            (new SeccionController())->cargarFormularioSeccion($request);
            break;

        case 'agregarSeccion':
            $request = (new GuardMiddleware())->run($request);
            (new SeccionController())->agregarSeccion($request);
            break;

        case 'editarSeccion':
            $request = (new GuardMiddleware())->run($request);
            (new SeccionController())->cargarFormularioEditarSeccion($request);
            break;

        case 'modificarSeccion':
            $request = (new GuardMiddleware())->run($request);
            (new SeccionController())->modificarSeccion($request);
            break;

        case 'mostrarNoticia':
            (new NoticiasController())->show($request);
            break;

        case 'eliminarNoticia':
            $request = (new GuardMiddleware())->run($request);
            (new NoticiasController())->delete($request);
            break;

        case 'agregarNoticia':
            $request = (new GuardMiddleware())->run($request);
            (new NoticiasController())->add();
            break;

        case 'modificarNoticia':
            $request = (new GuardMiddleware())->run($request);
            (new NoticiasController())->cargarFormularioEditar($request);
            break;

        case 'login':
            (new AuthController())->doLogin($request);
            break;

        case 'validate':
            (new AuthController())->validate($request);
            break;

        case 'register':
            (new AuthController())->registrar($request);
            break;

        case 'logout':
            (new AuthController())->logout();
            break;

        default: 
            header('Location: ' . BASE_URL . 'home');
            die();
    }