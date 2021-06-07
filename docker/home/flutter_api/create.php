<?php
header('Content-Type: application/json');
include "../flutter_api/db.php";


// $name = $_POST['name'];
// $age = (int) $_POST['age'];

$name = $_POST['name'];
$age = (int) $_POST['age'];

// $stmt = $db->prepare("INSERT INTO student (name, age) VALUES (?, ?)");
// $result = $stmt->execute([$name, $age]);

$stmt = mysqli_query($db, "INSERT INTO student (name, age) VALUES (.$name., .$age.)");
// $result = $stmt->execute([$name, $age]);
// $result = mysqli_fetch_array($stmt);

// echo json_encode([
// 'success' => $result
// ]);

?>
