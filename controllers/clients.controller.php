<?php
    class ClientsController {

        public function create() {
            $json = array(
                "details" => "You're in register"
            );
        
            echo json_encode($json, true);
            return;
        }
    }
?>