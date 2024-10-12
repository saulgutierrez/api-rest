<?php
    class CoursesController {
        public function index () {

            // Get all data into clientes table
            $clients = ClientsModel::index("clientes");

            // Validate auth credentials, capturate from API Auth screen
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

        public function create ($data) {
            // Validate client credentials, getting all data into clients table
            $clients = ClientsModel::index("clientes");
            // Validate auth credentials, capturate from API Auth screen
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                foreach ($clients as $key => $valueClient) {
                    // Search for user credentials in database
                    if (base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($valueClient["id_cliente"].":".$valueClient['llave_secreta'])) {
                        // If user exists, then validate data for new course
                        // Checking for each field of the course data array
                        foreach ($data as $key => $valueData) {
                            // Avoid special characters in the input
                            if (isset($valueData) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueData)) {
                                $json = array(
                                    "status" => 404,
                                    "details" => "The field ".$key." is settled wrong"
                                );

                                echo json_encode($json, true);
                                return;
                            }
                        }
                    }
                }

                // Validate that the title or description is not repeated
                $courses = CoursesModel::index("cursos");

                foreach ($courses as $key => $value) {
                    // Comparate title and description
                    if ($value->titulo == $data["title"]) {
                        $json = array(
                            "status" => 404,
                            "details" => "The title is already in the database"
                        );

                        echo json_encode($json, true);
                        return;
                    }

                    if ($value->descripcion == $data["description"]) {
                        $json = array(
                            "status" => 404,
                            "details" => "The description is already in the database"
                        );

                        echo json_encode($json, true);
                        return;
                    }
                }

                // Carry data to the model
                $data = array(
                    "title" => $data["title"],
                    "description" => $data["description"],
                    "instructor" => $data["instructor"],
                    "image" => $data["image"],
                    "price" => $data["price"],
                    "id_creator" => $valueClient["id"],
                    "created_at" => date('Y-m-d h:i:s'),
                    "updated_at" => date('Y-m-d h:i:s')
                );

                $create = CoursesModel::create("cursos", $data);

                // Response from model
                if ($create == "ok") {
                    $json = array(
                        "status" => 200,
                        "details" => "Inserted successfully"
                    );

                    echo json_encode($json, true);
                    return;
                }
            }
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