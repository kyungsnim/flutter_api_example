<?php
header('Content-Type: application/json');
include "../flutter_api/db.php";

$stmt = $db->prepare("SELECT id, name, age FROM student");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);