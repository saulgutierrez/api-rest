<?php
    class CoursesController {
        public function index () {
            // Fetch all records
            $courses = CoursesModel::index("cursos");
            $json = array(
                "details" => $courses
            );
        
            echo json_encode($json, true);
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