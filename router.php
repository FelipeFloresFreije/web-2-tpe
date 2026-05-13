<?php
    require_once __DIR__ . '/app/controllers/noticias.controller.php';

    define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

    // maneja las peticiones GET
    $action = 'noticias';

    if (!empty($_GET['action'])) {
        $action = $_GET['action'];
    }

    $params = explode('/', $action);

    // maneja las peticiones POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
        $controller = new NoticiasController();

        switch ($action) {
            case 'add':
                $controller->add();
                break;

            case 'editar':
                $controller->editar($_POST['editar_id']);
                break;

            case 'delete':
                $controller->delete($_POST['id']);
                break;
        }

        exit;
    }

    switch ($params[0]) {
        case 'noticias':
            $controller = new NoticiasController();
            $controller->showAll();
            $controller->showForm();
            break;    

        case 'noticia':
            if (empty($params[1])) {
                echo '404 error';
                break;
            }
            $controller = new NoticiasController();
            $controller->show($params[1]);
            break;
        
        case 'editar':
                $controller = new NoticiasController();
                if (empty($params[1])) {
                    echo '404 error';
                    break;
                }
                $controller->showEditForm($params[1]);
                break;    

        default:
            echo '404 error';
            break;
    }
?>