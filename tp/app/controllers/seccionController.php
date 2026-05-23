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
            $user = $request->user;
            $this->seccionView->renderIndex($noticias, $secciones, $user);
        }
/*
        function mostrarSeccion($request){
            $noticias= $this->noticiasModel->get($request->id);
            $seccion= $this->seccionModel->get($request->id);
            $this->seccionView->showSeccion($seccion,$noticias,$request->user);
        }
        function removeSeccion($request){
            if($request->user!=null){
                // obtengo la tarea que quiero eliminar
                $seccion = $this->seccionModel->get($request->id);
                $noticias= $this->noticiasModel->get($request->id);
        
                if ($noticias) {
                    return $this->seccionView->showError("La categoría con ID = $request->id ({$seccion->nombre}) no se puede eliminar porque tiene noticias asociadas.",$request->user);
                }
            
                $this->seccionModel->remove($request->id);
        
                // redirijo al home
                header('Location: ' . BASE_URL);
            }else{
                $this->seccionView->showError("no tiene los privilegios",null);
            }
        }
        function agregarSeccion($request) {
            if($request->user!=null){
            if (!isset($_POST['descripcion']) || empty($_POST['descripcion'])) {
                return $this->seccionView->showError('Error: falta completar la descripcion',$request->user);
            }
    
            if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
                return $this->seccionView->showError('Error: falta completar el nombre',$request->user);
            }
    
            // obtengo los datos del formulario
            $descripcion = $_POST['descripcion'];
            $nombre = $_POST['nombre'];
    
            $id = $this->seccionModel->insert($descripcion, $nombre);
    
            if (!$id) {
                return $this->seccionView->showError('Error la insertar tarea',$request->user);
            } 
    
            // redirijo al home
            header('Location: ' . BASE_URL .'home');
            }else{
                $this->seccionView->showError("no tiene los privilegios",null);
            }
        }
        public  function modificarSeccion($request) {
            if($request->user!=null){
                if (!isset($_POST['id_seccion']) || empty($_POST['id_seccion'])) {
                    return $this->seccionView->showError('Error: falta seleccionar la seccion',$request->user);
                }
                if (!isset($_POST['descripcion']) || empty($_POST['descripcion'])) {
                    return $this->seccionView->showError('Error: falta completar la descripcion',$request->user);
                }
                if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
                    return $this->seccionView->showError('Error: falta completar el nombre',$request->user);
                }
                
                // obtengo los datos del formulario
                $id=$_POST['id_categoria'];
                $descripcion = $_POST['descripcion'];
                $nombre = $_POST['nombre'];
        
                $this->seccionModel->modificar($id, $descripcion, $nombre);
        
                // redirijo al home
                header('Location: ' . BASE_URL);
            }else{
                $this->seccionView->showError("no tiene los privilegios",null);
            }
        }*/
    }