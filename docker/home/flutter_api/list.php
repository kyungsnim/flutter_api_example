<?php
header('Content-Type: application/json');
include "../flutter_api/db.php";

// $stmt = $db->prepare("SELECT id, name, age FROM student");
// $stmt->execute();
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo json_encode($result);

// $stmt = mysqli_query($db, "SELECT id, name, age FROM student");
// // $stmt->execute();
// $mysqli = db();
// $mysqli->rows();

db()->rows("student");
// $result = mysqli_fetch_array($stmt);

// echo json_encode($result);

?>
