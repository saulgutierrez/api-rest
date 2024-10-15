<?php
    // Get the URL route
    $arrayRoutes = explode("/", $_SERVER['REQUEST_URI']);

    if (isset($_GET["page"]) && is_numeric($_GET['page'])) {
        $courses = new CoursesController();
        // Getting the URL value to show a limited amount of pages
        $courses->index($_GET['page']);
    } else {
        // Not request
        if (count(array_filter($arrayRoutes)) == 1) {
            $json = array(
                "details" => "not found"
            );
        
            echo json_encode($json, true);

            return;
        } else {
            // URL parameter (index = 2)
            if (count(array_filter($arrayRoutes)) == 2) {
                
                // Request from courses
                if(array_filter($arrayRoutes)[2] == "courses") {
                    // Evaluate GET/POST method
                    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {

                        // Capture courses data
                        $data = array (
                            "title" => $_POST['title'],
                            "description" => $_POST['description'],
                            "instructor" => $_POST['instructor'],
                            "image" => $_POST['image'],
                            "price" => $_POST['price']
                        );

                        $courses = new CoursesController();
                        $courses->create($data);

                    } else if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                        $courses = new CoursesController();
                        $courses->index(null);
                    }
                }

                // Request from register
                if(array_filter($arrayRoutes)[2] == "register") {
                    // Evaluate POST method
                    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                        $data = array (
                            "name" => $_POST['name'],
                            "surname" => $_POST['surname'],
                            "email" => $_POST['email']
                        );

                        $clients = new ClientsController();
                        $clients->create($data);
                    }
                }
            } else {
                // Check for the course index, for edit or delete a course, using id parameter
                if (array_filter($arrayRoutes)[2] == "courses"  && is_numeric(array_filter($arrayRoutes)[3])) {
                    // Evaluate GET method for getting info for a course
                    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                        $courses = new CoursesController();
                        $courses->show(array_filter($arrayRoutes)[3]);
                    }
                    // Evaluate PUT method, for edit info of a course
                    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "PUT") {
                        // Getting data
                        $data = array();

                        // Capture all data into the form, and parse it with parse_str function
                        parse_str(file_get_contents('php://input'), $data);
                        
                        $editCourse = new CoursesController();
                        // Take off the data into the form towards the update function
                        $editCourse->update(array_filter($arrayRoutes)[3], $data);
                    }
                    // Evaluate DELETE method
                    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "DELETE") {
                        $deleteCourse = new CoursesController();
                        $deleteCourse->delete(array_filter($arrayRoutes)[3]);
                    }
                }
            }
        }
    }
?>