<?php

    require_once "connection.php";

    class CoursesModel {
        static public function index ($table) {
            $statement = Connection::connect()->prepare("SELECT * FROM $table");
            $statement->execute();
            # Return properties of the connection
            return $statement->fetchAll(PDO::FETCH_CLASS);
            $statement->close();
            $statement = null;
        }
    }
?>