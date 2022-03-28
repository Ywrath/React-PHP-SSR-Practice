<?php

class ParentController {
    protected function respond_unprocessable_entity(array $errors): void {
        http_response_code(422);
        echo json_encode(["errors" => $errors]);
    }

    protected function respond_method_not_allowed(string $allowed_methods): void {
        http_response_code(405);
        header("Allow: $allowed_methods");
        echo json_encode(["message" => "Not allowed"]);
    }

    public function resource_not_found(): void {
        http_response_code(404);
        echo json_encode(["message" => "Resource not found"]);
    }
}