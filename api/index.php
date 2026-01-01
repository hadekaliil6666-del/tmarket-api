<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$uri = $_SERVER['REQUEST_URI'];
if (preg_match('/\/api\/(.+)/', $uri, $matches)) {
    $file = 'api/' . $matches[1];
    if (file_exists($file)) {
        chdir('api');
        include $file;
        exit;
    }
}
echo json_encode(['error' => 'Use /api/login.php']);
?>
