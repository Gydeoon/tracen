<?php
session_start();
require_once 'config/database.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM trainees WHERE id = :id");
    if($stmt->execute([':id' => $_GET['id']])) {
        $_SESSION['message'] = "Trainee record successfully retired.";
    }
}
header("Location: index.php");
exit();
?>