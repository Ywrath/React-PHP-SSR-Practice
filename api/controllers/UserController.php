<?php
require dirname(__DIR__) . "/models/UserModel.php";

class UserController extends ParentController {
    public function process_request(string $method, string $action) {
        $request_body = (array) json_decode(file_get_contents("php://input"), true);

        if($method == "POST") {
            // print_r($request_body);
            if(empty($request_body)) {
                echo $this->respond_unprocessable_entity(["No data received!"]);
                return;
            }
            switch($action) {
                case "sign-up":
                    $user = new UserModel();
                    $result = $user->create_user($request_body);
                    if($result) {
                        $new_user = $user->get_user_by_email($result);
                        if($new_user) {
                        echo json_encode($new_user);       
                        } else {
                            http_response_code(500);
                            echo json_encode(["status" => "failed", "message" => "Something went wrong creating the account."]);
                        }
                    }
                    break;
                case "login":
                    $user = new UserModel();
                    $email_exists = $user->email_exists($request_body['email']);
                    if($email_exists) {
                        $result = $user->login($request_body['email'], $request_body['password']);
                        if($result) {
                            http_response_code(200);
                            echo json_encode($result);
                        } else {
                            http_response_code(403);
                            echo json_encode(["message" => "Invalid username or password"]);
                        }
                    } else {
                        http_response_code(404);
                        echo json_encode(["message" => "User does not have an account yet."]);
                    }
                    break;
                case "profile":
                    $user = new UserModel();
                    $result = $user->get_user_by_email($request_body['email']);
                    if($result) {
                        http_response_code(200);
                        echo json_encode($result);
                    } else {
                        http_response_code(404);
                        echo json_encode(["message" => "User not found"]);
                    }
                    break;
                default:
                    $this->resource_not_found();
                    break;
            }
        } else {
            $this->respond_method_not_allowed("POST");
        }
    }
}