<?php

    require_once "connection.php";

    class CoursesModel {
        // Show all records
        static public function index ($table1, $table2) {
            // $table1 = "cursos", "$table2 = "clientes"
            $statement = Connection::connect()->prepare("SELECT $table1.id, $table1.titulo, $table1.descripcion, $table1.instructor, $table1.precio, $table1.id_creador, $table2.nombre, $table2.apellido FROM $table1 INNER JOIN $table2 ON $table1.id_creador = $table2.id");
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
        static public function show ($table1, $table2, $id) {
            $statement = Connection::connect()->prepare("SELECT $table1.id, $table1.titulo, $table1.descripcion, $table1.instructor, $table1.precio, $table1.id_creador, $table2.nombre, $table2.apellido FROM $table1 INNER JOIN $table2 ON $table1.id_creador = $table2.id WHERE $table1.id = :id");
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

        // Delete an specific record
        static public function delete($table, $id) {
            $statement = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
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