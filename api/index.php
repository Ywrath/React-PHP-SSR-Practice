<?php
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/src/ErrorHandler.php";

set_error_handler("ErrorHandler::handle_error");
set_exception_handler("ErrorHandler::handle_exception");

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$parts = explode("/", $path);

$resource = $parts[2];

$action = $parts[3] ?? null;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE');
header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  header('HTTP/1.1 200 OK');
  exit();
}
header("Content-type: application/json; charset=UTF-8");


// echo json_encode(["resource" => $resource, "action" => $action]);
switch ($resource) {
    case 'user':
        $user = new UserController(); 
        $user->process_request($_SERVER['REQUEST_METHOD'], $action);
        break;
    default:
        $controller = new ParentController();
        $controller->resource_not_found();
        break; 
}
