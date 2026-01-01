<?php
require_once 'db_connect.php';
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

header('Access-Control-Allow-Origin: *');  // ✅ يسمح للمتصفح
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "يجب استخدام POST"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$phone = trim($data['phone'] ?? '');
$password = $data['password'] ?? '';

if (empty($phone) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "رقم الهاتف وكلمة المرور مطلوبان"]);
    exit();
}

try {
    $stmt = $conn->prepare("SELECT id, name, phone, email, password FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "رقم الهاتف غير موجود"]);
        exit();
    }

    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        unset($user['password']); // إزالة كلمة المرور من الاستجابة
        echo json_encode([
            "status" => "success",
            "user" => [  
                "id" => $user['id'],
                "name" => $user['name'],
                "phone" => $user['phone'],
                "email" => $user['email'] ?? ''
            ]
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "كلمة مرور غير صحيحة"]);
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "خطأ في الخادم: " . $e->getMessage()]);
}
?>
