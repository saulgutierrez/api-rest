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
                        // Added multiple selection
                        $courses = CoursesModel::index("cursos", "clientes");
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
                $courses = CoursesModel::index("cursos", "clientes");

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
            // Validate credentials
            $clients = ClientsModel::index("clientes");
            // Validate auth credentials, capturate from API Auth screen
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                foreach ($clients as $key => $valueClient) {
                    // Search for user credentials in database
                    if (base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($valueClient["id_cliente"].":".$valueClient['llave_secreta'])) {
                        // Show all courses with an specific id
                        $courses = CoursesModel::show("cursos", "clientes", $id);

                        if (!empty($courses)) {
                            $json = array(
                                "status" => 200,
                                "details" => $courses
                            );
                        
                            echo json_encode($json, true);
                            return;
                        } else {
                            $json = array(
                                "status" => 200,
                                'total_records' => 0,
                                "details" => "There aren't any course"
                            );
                        
                            echo json_encode($json, true);
                            return;
                        }
                    }
                }
            }
        }

        public function update ($id, $data) {
            // Validate credentials
            $clients = ClientsModel::index("clientes");
            // Validate auth credentials, capturate from API Auth screen
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                foreach ($clients as $key => $valueClient) {
                    // Search for user credentials in database
                    if (base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($valueClient["id_cliente"].":".$valueClient['llave_secreta'])) {
                        // If user exists, then validate data for update a course
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

                        // Validate creator id, avoid to edit any course who isn´t belongs to him
                        $course = CoursesModel::show("cursos", "clientes", $id);
                        foreach ($course as $key => $valueCourse) {
                            // Compare if id_creador field in course table is equal to client id
                            // That means the course belongs to the client
                            if ($valueCourse->id_creador == $valueClient["id"]) {
                                // Bring the data into the model
                                $data = array(
                                    "id" => $id,
                                    "title" => $data['title'],
                                    "description" => $data['description'],
                                    "instructor" => $data['instructor'],
                                    "image" => $data['image'],
                                    "price" => $data['price'],
                                    "updated_at" => date('Y-m-d h:i:s')
                                );

                                $update = CoursesModel::update("cursos", $data);

                                if ($update == "ok") {
                                    $json = array(
                                        "status" => 200,
                                        "details" => "Course updated successfully"
                                    );
                                
                                    echo json_encode($json, true);
                                    return;
                                } else {
                                    $json = array(
                                        "status" => 404,
                                        "details" => "Failed authorization to modified this record"
                                    );
                                
                                    echo json_encode($json, true);
                                    return;
                                }
                            }
                        }
                    }
                }
            }
        }

        public function delete ($id) {
            // Validate credentials
            $clients = ClientsModel::index("clientes");
            // Validate auth credentials, capturate from API Auth screen
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                foreach ($clients as $key => $valueClient) {
                    // Search for user credentials in database
                    if (base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($valueClient["id_cliente"].":".$valueClient['llave_secreta'])) {
                        // Validate creator id
                        $course = CoursesModel::show("cursos", "clientes", $id);
                        // Search for the creator id
                        foreach ($course as $key => $valueCourse) {
                            // Compare course id with id_creador field in clients table
                            if ($valueCourse->id_creador == $valueClient["id"]) {
                                // Bring the data into the model
                                $delete = CoursesModel::delete("cursos", $id);

                                if ($delete == "ok") {
                                    $json = array(
                                        "status" => 200,
                                        "details" => "Course deleted successfully"
                                    );
                                
                                    echo json_encode($json, true);
                                    return;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>