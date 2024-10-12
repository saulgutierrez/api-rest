<?php
    require_once "connection.php";

    class ClientsModel {
        // Show all records
        static public function index($table) {
            $statement = Connection::connect()->prepare("SELECT * FROM $table");
            $statement->execute();
            return $statement->fetchAll();
            $statement->close();
            $statement = null;
        }

        // Register new user
        static public function create($table, $data) {
            $statement = Connection::connect()->prepare("INSERT INTO clientes(nombre, apellido, email, id_cliente, llave_secreta, created_at, updated_at) VALUES (:nombre, :apellido, :email, :id_cliente, :llave_secreta, :created_at, :updated_at)");

            $statement->bindParam(":nombre", $data['name'], PDO::PARAM_STR);
            $statement->bindParam(":apellido", $data['surname'], PDO::PARAM_STR);
            $statement->bindParam(":email", $data['email'], PDO::PARAM_STR);
            $statement->bindParam(":id_cliente", $data['client_id'], PDO::PARAM_STR);
            $statement->bindParam(":llave_secreta", $data['client_key'], PDO::PARAM_STR);
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
    }
?>