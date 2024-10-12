<?php
    class CoursesController {
        public function index () {

            // Get all data into clientes table
            $clients = ClientsModel::index("clientes");

            // Validate auth credentials
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                // Search for user credentials in database use $clients variable, that contains all database clients
                foreach($clients as  $key => $value) {
                    if (base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($value['id_cliente'].":".$value['llave_secreta'])) {
                        // Fetch all records
                        $courses = CoursesModel::index("cursos");
                        $json = array(
                            "details" => $courses
                        );
                    
                        echo json_encode($json, true);
                        return;
                    }
                }
            }
        }

        public function create () {
            $json = array(
                "details" => "You're in create courses"
            );
        
            echo json_encode($json, true);
        }

        public function show ($id) {
            $json = array(
                "details" => "ID of this course: " .$id
            );
        
            echo json_encode($json, true);
        }

        public function update ($id) {
            $json = array(
                "details" => "Course ID " .$id. " updated successfully"
            );
        
            echo json_encode($json, true);
        }

        public function delete ($id) {
            $json = array(
                "details" => "Course ID " .$id. " deleted successfully"
            );
        
            echo json_encode($json, true);
        }
    }
?>