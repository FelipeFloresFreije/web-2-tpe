<?php
    require_once './app/models/noticiasModel.php';
    require_once './app/models/seccionModel.php';
    require_once './app/views/seccionView.php';

    class SeccionController{
        private $noticiasModel;
        private $seccionModel;
        private $seccionView;

        function __construct(){
            $this->noticiasModel = new NoticiasModel();
            $this->seccionModel = new seccionModel();
            $this->seccionView = new seccionView();
        }

        function showSeccion($request){
            $secciones= $this->seccionModel->getAll();
            $noticias = $this->noticiasModel->getAll();
            $this->seccionView->renderIndex($noticias, $secciones, $request->user);
        }

        function mostrarSeccion($request){
            $seccion= $this->seccionModel->get($request->id);
            $noticias = $this->noticiasModel->getAll(); 
            $this->seccionView->showSeccion($seccion,$noticias,$request->user);
        }
        function removeSeccion($request){
            $this->seccionModel->remove($request->id);
            header('Location: ' . BASE_URL);
        }
        function agregarSeccion($request) {
            if (empty($_POST['nombre']) || empty($_POST['descripcion'])) {
                return $this->seccionView->showError('Error: campos obligatorios vacíos', $request->user);
            }
    
            $this->seccionModel->insert($_POST['descripcion'], $_POST['nombre']);
            header('Location: ' . BASE_URL);
        }
        public  function modificarSeccion($request) {
            if (empty($_POST['id_seccion']) || empty($_POST['nombre']) || empty($_POST['descripcion'])) {
                return $this->seccionView->showError('Error: faltan datos para modificar', $request->user);
            }
    
            $this->seccionModel->modificar($_POST['id_seccion'], $_POST['descripcion'], $_POST['nombre']);
            header('Location: ' . BASE_URL);
        }
    }