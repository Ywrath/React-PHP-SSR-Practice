<?php

class ErrorHandler {
    public static function handle_exception(Throwable $exception): void {
        http_response_code(500);
        echo json_encode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        ]);
    }

    public static function handle_error(int $err_num, string $err_str, string $err_file, int $err_line): void {
        throw new ErrorException($err_str, 0, $err_num, $err_file, $err_line);
        
    }
}