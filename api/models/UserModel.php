<?php
require "Model.php";

class UserModel extends Model {
    public function login(string $email, string $password) {
        $sql = "SELECT * FROM user WHERE email=:email AND password=:password";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();
        
        if($user) {
            return [
                "id" => $user['id'], 
                "fullname" => $user['full_name'], 
                "email" => $user['email'], 
                "desc" => $user['desc'], 
                "age" => $user['age']
            ];
        } else {
            return false;
        }

        return $user;
        
    }

    public function create_user(array $request_body) {
        $sql = "INSERT INTO user (`full_name`, `email`, `password`, `desc`, `age`) VALUES (:full_name, :email, :password, :desc, :age)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam("full_name", $request_body['full-name'], PDO::PARAM_STR);
        $stmt->bindParam("email", $request_body['email'], PDO::PARAM_STR);
        $stmt->bindParam("password", $request_body['password'], PDO::PARAM_STR);
        $stmt->bindParam("desc", $request_body['desc'], PDO::PARAM_STR);
        $stmt->bindParam("age", $request_body['age'], PDO::PARAM_STR);

        $stmt->execute();

        $id = $this->conn->lastInsertId();

        return $id;
    }

    public function email_exists(string $email) {
        $sql = "SELECT email FROM user WHERE email=:email";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam("email", $email, PDO::PARAM_STR);

        $stmt->execute();

        $count = $stmt->rowCount();

        if($count) {
            return true;
        } else {
            return false;
        }
    }

    public function get_user_by_id(int $id) {
        $sql = "SELECT * FROM user WHERE id=:id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch();
        if($user) {
            return [
                "id" => $user['id'], 
                "fullname" => $user['full_name'], 
                "email" => $user['email'], 
                "desc" => $user['desc'], 
                "age" => $user['age']
            ];
        } else {
            return false;
        }

    }

    public function get_user_by_email(string $email) : array | false {
        $sql = "SELECT * FROM user WHERE email=:email";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam("email", $email, PDO::PARAM_STR);

        $stmt->execute();
        
        $user_data = $stmt->fetch();

        if($user_data) {
            return [
                "fullname" => $user_data['full_name'],
                "email" => $user_data['email'],
                "desc" => $user_data['desc'],
                "age" => $user_data['age']
            ];
        } else {
            return false;
        }
    }
}