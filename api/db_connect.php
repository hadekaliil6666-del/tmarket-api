<?php
// ========================================
// بيانات الاتصال المحلية XAMPP (فعّالة الآن)
// ========================================
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'tmarket_db';

// ========================================
// بيانات الاستضافة InfinityFree (علّق عند الرفع)
// ========================================
/*
$host = 'sql309.infinityfree.com';
$username = 'if0_40787669';
$password = 'rQVLM4VtQtt';
$dbname = 'if0_40787669_tmarket_db';
*/

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("خطأ الاتصال: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// CORS headers (اختياري - للـ API فقط)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
?>
