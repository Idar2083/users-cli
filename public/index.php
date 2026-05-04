<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . '/../src/RepositoryFactory.php';

use function Tsimib\UsersCli\createRepository;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$repository = createRepository();

header("Content-Type: application/json; charset=utf-8");

$method = $_SERVER["REQUEST_METHOD"];
$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($method === "GET" && $uri === '/users') {
    http_response_code(200);
    echo json_encode($repository->getAllUsers(), JSON_PRETTY_PRINT);
    exit;
}

if ($method === "POST" && $uri === '/users') {

    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Name is required']);
        exit;
    }

    $user = $repository->addUser($input['name']);

    http_response_code(201);
    echo json_encode($user);
    exit;
}

if ($method === "DELETE") {

    $parts = explode('/', $uri);

    if (count($parts) === 3 && $parts[1] === 'users') {

        $id = (int)$parts[2];

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid ID']);
            exit;
        }

        $repository->deleteUser($id);

        http_response_code(204);
        exit;
    }
}

http_response_code(404);
echo json_encode(['error' => 'Not found']);

