<?php
    class ClientsController {

        public function create($data) {
            // Validate name
            if (isset($data['name']) && !preg_match('/^[a-zA-Z-ZáéíóúÁÉÍÓÚñÑ ]+$/' , $data["name"])) {
                $json = array(
                    "status" => 404,
                    "details" => "Error. Enter only letters."
                );
                echo json_encode($json, true);
                return;
            }

            // Validate surname
            if (isset($data['surname']) && !preg_match('/^[a-zA-Z-ZáéíóúÁÉÍÓÚñÑ ]+$/' , $data["surname"])) {
                $json = array(
                    "status" => 404,
                    "details" => "Error. Enter only letters."
                );
                echo json_encode($json, true);
                return;
            }

            // Validate email
            if (isset($data['email']) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $data["email"])) {
                $json = array(
                    "status" => 404,
                    "details" => "Error. Email is not formatted correctly"
                );
                echo json_encode($json, true);
                return;
            }
        }
    }
?>