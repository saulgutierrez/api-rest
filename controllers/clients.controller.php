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

            // Validate duplicate email
            // Get all records from the model
            $clients = ClientsModel::index("clientes");

            foreach ($clients as $key => $value) {
                // Compare if email from text field is same as any email in database
                if ($value["email"] == $data['email']) {
                    $json = array(
                        "status" => 404,
                        "details" => "Email is duplicated"
                    );

                    echo json_encode($json, true);
                    return;
                }
            }

            // Generate client key
            $clientID = str_replace("$", "c", crypt($data['name'].$data['surname'].$data['email'], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
            $clientKey = str_replace("$", "a", crypt($data['email'].$data['surname'].$data['name'], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));

            $data = array(
                        "name" => $data['name'],
                        "surname" => $data['surname'],
                        "email" => $data['email'],
                        "client_id" => $clientID,
                        "client_key" => $clientKey,
                        "created_at" => date('Y-m-d h:i:s'),
                        "updated_at" => date('Y-m-d h:i:s')
                    );

            $create = ClientsModel::create("clientes", $data);

            if ($create == "ok") {
                $json = array(
                    "status" => 404,
                    "details" => "Inserted successfully",
                    "client_id" => $clientID,
                    "client_key" => $clientKey
                );

                echo json_encode($json, true);
                return;
            }
        }
    }
?>