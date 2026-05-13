<?php

require_once __DIR__ . '/../models/noticias.model.php';
require_once __DIR__ . '/../views/noticias.view.php';
require_once __DIR__ . '/../models/seccion.model.php';

class NoticiasController {
    private $model;
    private $view;
    private $seccionModel;
    

    public function __construct() {
        $this->model = new NoticiasModel();
        $this->view = new NoticiasView();
        $this->seccionModel = new SeccionModel();
    }

    public function showEditForm($id) {
        $noticia = $this->model->get($id);
        if (!$noticia) {
            echo "<p>No existe la noticia con el id=$id</p>";
            return; // para la función acá
        }

        $secciones = $this->seccionModel->getAll();
        $this->view->showEditForm($secciones, $noticia);
    }

    public function showAll() {
        // obtiene las noticias
        $noticias = $this->model->getAll();

        // envia las noticias a la vista
        $this->view->showNoticias($noticias);
    }

    public function showForm() {
        $secciones = $this->seccionModel->getAll(); // trae las secciones
        $this->view->showForm($secciones);
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
        $id = $_POST['editar_id'];
        $titulo = $_POST['editar_titulo'];
        $cuerpo = $_POST['editar_cuerpo'];
        $fecha = $_POST['editar_fecha'];
        $id_seccion_fk = $_POST['editar_id_seccion_fk'];

        $this->model->editar($id, $titulo, $cuerpo, $fecha, $id_seccion_fk);

        header("Location: " . BASE_URL);
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
        }

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

    public function show($id) {
        $noticia = $this->model->get($id);
        if (!$noticia) {
            echo "No existe la noticia con el id=$id";
            return;
        }
        $this->view->showNoticia($noticia);
    }
    
}