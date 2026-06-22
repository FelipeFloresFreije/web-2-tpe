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
            $secciones = $this->seccionModel->getAll();
            $noticias = $this->noticiasModel->getAll();
            $this->seccionView->renderIndex($noticias, $secciones, $request->user);
        }

        public function mostrarSeccion($request) {
            $seccion = $this->seccionModel->get($request->id);
            $secciones = $this->seccionModel->getAll();
            $noticias = $this->noticiasModel->getAll();
            
            $this->seccionView->showSeccion($seccion, $secciones, $noticias, $request->user);
        }

        public function cargarFormularioSeccion($request) {
            $this->seccionView->renderFormSeccion($request->user);
        }

        public function cargarFormularioEditarSeccion($id_seccion, $request) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $seccion = $this->seccionModel->get($id_seccion);
            
            $user = isset($request->user) ? $request->user : (object)['logueado' => true];

            $this->seccionView->renderFormEditarSeccion($seccion, $user);
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

        public function modificarSeccion($request) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_POST['id_seccion']) || !isset($_POST['nombre']) || !isset($_POST['descripcion'])) {
                die("Error: No llegaron los datos del POST");
            }

            $id = $_POST['id_seccion'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];

            $this->seccionModel->modificar($id, $descripcion, $nombre);

            header('Location: ' . BASE_URL . 'home');
            die();
        }
    }