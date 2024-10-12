<?php

    require_once "connection.php";

    class CoursesModel {
        // Show all records
        static public function index ($table) {
            $statement = Connection::connect()->prepare("SELECT * FROM $table");
            $statement->execute();
            # Return properties of the connection
            return $statement->fetchAll(PDO::FETCH_CLASS);
            $statement->close();
            $statement = null;
        }

        // Register new course
        static public function create ($table, $data) {
            $statement = Connection::connect()->prepare("INSERT INTO $table(titulo, descripcion, instructor, imagen, precio, id_creador, created_at, updated_at) VALUES(:titulo, :descripcion, :instructor, :imagen, :precio, :id_creador, :created_at, :updated_at)");

            $statement->bindParam(":titulo", $data['title'], PDO::PARAM_STR);
            $statement->bindParam(":descripcion", $data['description'], PDO::PARAM_STR);
            $statement->bindParam(":instructor", $data['instructor'], PDO::PARAM_STR);
            $statement->bindParam(":imagen", $data['image'], PDO::PARAM_STR);
            $statement->bindParam(":precio", $data['price'], PDO::PARAM_STR);
            $statement->bindParam(":id_creador", $data['id_creator'], PDO::PARAM_STR);
            $statement->bindParam(":created_at", $data['created_at'], PDO::PARAM_STR);
            $statement->bindParam(":updated_at", $data['updated_at'], PDO::PARAM_STR);

            if ($statement->execute()) {
                return "ok";
            } else {
                print_r(Connection::connect()->errorInfo());
            }
            
            $statement->close();
            $statement = null;
        }

        // Show an specific record
        static public function show ($table, $id) {
            $statement = Connection::connect()->prepare("SELECT * FROM $table WHERE id = :id");
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            # Return properties of the connection
            return $statement->fetchAll(PDO::FETCH_CLASS);
            $statement->close();
            $statement = null;
        }

        // Update an specific record
        static public function update ($table, $data) {
            $statement = Connection::connect()->prepare("UPDATE cursos SET titulo=:titulo,descripcion=:descripcion,instructor=:instructor,imagen=:imagen,precio=:precio,updated_at=:updated_at WHERE id=:id");

            $statement->bindParam(":id", $data['id'], PDO::PARAM_STR);
            $statement->bindParam(":titulo", $data['title'], PDO::PARAM_STR);
            $statement->bindParam(":descripcion", $data['description'], PDO::PARAM_STR);
            $statement->bindParam(":instructor", $data['instructor'], PDO::PARAM_STR);
            $statement->bindParam(":imagen", $data['image'], PDO::PARAM_STR);
            $statement->bindParam(":precio", $data['price'], PDO::PARAM_STR);
            $statement->bindParam(":updated_at", $data['updated_at'], PDO::PARAM_STR);

            if ($statement->execute()) {
                return "ok";
            } else {
                print_r(Connection::connect()->errorInfo());
            }
            
            $statement->close();
            $statement = null;
        }
    }
?>