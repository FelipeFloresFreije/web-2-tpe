<?php

require_once __DIR__ . '/../models/noticiasModel.php';
require_once __DIR__ . '/../views/noticiasView.php';
require_once __DIR__ . '/../models/seccionModel.php';

class NoticiasController {
    private $model;
    private $view;
    private $seccionModel;
    

    public function __construct() {
        $this->model = new NoticiasModel();
        $this->view = new NoticiasView();
        $this->seccionModel = new SeccionModel();
    }

    public function cargarFormularioEditar($id, $user) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->editar($id, $_POST['editar_titulo'], $_POST['editar_cuerpo'], $_POST['editar_fecha'], $_POST['editar_id_seccion_fk']);
            header('Location: ' . BASE_URL . 'home');
            die();
        }
        $id_editar = $id;
        $secciones = $this->seccionModel->getAll();
        $noticia = $this->model->get($id); 
        include './templates/form_modificar.phtml';
    }

    public function delete($id) {
        $task = $this->model->get($id);
        if (!$task) {
            echo "<p>No existe la noticia con el id=$id</p>";
            return; // para la función acá
        }
        
        $this->model->delete($id);

        header("Location: " . BASE_URL );
    }
    
    public function editar($id) {
        //validaciones
        if (
            !isset($_POST['editar_titulo']) || empty($_POST['editar_titulo']) ||
            !isset($_POST['editar_cuerpo']) || empty($_POST['editar_cuerpo']) ||
            !isset($_POST['editar_fecha']) || empty($_POST['editar_fecha']) ||
            !isset($_POST['editar_id_seccion_fk']) || empty($_POST['editar_id_seccion_fk'])
        ) {
            //redirigimos al home en caso de datos mal ingresados
            header("Location: " . BASE_URL . "home");
            die();
        } else {
            $noticia = $this->model->get($id);
            if (!$noticia) {
                header("Location: " . BASE_URL . "home");
                die();
            }      

            $titulo = $_POST['editar_titulo'];
            $cuerpo = $_POST['editar_cuerpo'];
            $fecha = $_POST['editar_fecha'];
            $id_seccion_fk = $_POST['editar_id_seccion_fk'];

            $this->model->editar($id, $titulo, $cuerpo, $fecha, $id_seccion_fk);

            header("Location: " . BASE_URL . "home");
            die();
        }
    }
    
    public function add() {       
        // valida la entrada de usuario
        if (
            !isset($_POST['titulo']) || empty($_POST['titulo']) ||
            !isset($_POST['cuerpo']) || empty($_POST['cuerpo']) ||
            !isset($_POST['fecha']) || empty($_POST['fecha']) ||
            !isset($_POST['id_seccion_fk']) || empty($_POST['id_seccion_fk'])
        ) {
            echo "Por favor, complete todos los campos.";
        } else {
        
            // obtiene los datos del formulario
            $titulo = $_POST['titulo'];
            $cuerpo = $_POST['cuerpo'];
            $fecha = $_POST['fecha'];
            $id_seccion_fk = $_POST['id_seccion_fk'];

            // inserta la nueva noticia en la DB
            $id = $this->model->insert($titulo, $cuerpo, $fecha, $id_seccion_fk);

            if (empty($id)) {
                echo "Error al agregar la noticia. Intente nuevamente.";
            }
            
            // redirige a la lista de noticias
            header("Location: " . BASE_URL );        
        }
    }
    public function show($id) {
        $noticia = $this->model->get($id);
        if (!$noticia) {
            echo "No existe la noticia con el id=$id";
            return;
        }
        $this->view->showNoticia($noticia);
    }
}