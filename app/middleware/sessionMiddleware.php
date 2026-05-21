<?php

    class sessionMiddleware {

        public function run($request){
            if(isset($_SESSION['USER_ID'])){
                $request->user = new StdClass();
                $request->user->id = $_SESSION['USER_ID'];
                $request->user->username = $_SESSION['USER_NAME'];
                $request->user->rol = $_SESSION['ROLE_USER']; 
            } else {
                $request->user = null;
            }
            return $request;
        }

    }