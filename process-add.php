<?php
session_start();
require_once 'config/database.php';
require_once 'includes/rating.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = calculateRatingScore(
        $_POST['stat_speed'], $_POST['stat_stamina'], $_POST['stat_power'],
        $_POST['stat_guts'], $_POST['stat_wit']
    );
    $rank = calculateFinalRank($score);

    $query = "INSERT INTO trainees (character_id, stat_speed, stat_stamina, stat_power, stat_guts, stat_wit, final_rank, rating_score, notes) 
              VALUES (:char_id, :spd, :sta, :pow, :gut, :wit, :rank, :score, :notes)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':char_id' => $_POST['character_id'], 
        ':rank' => $rank, 
        ':score' => $score, 
        ':notes' => $_POST['notes'],
        ':spd' => $_POST['stat_speed'], ':sta' => $_POST['stat_stamina'], ':pow' => $_POST['stat_power'], 
        ':gut' => $_POST['stat_guts'], ':wit' => $_POST['stat_wit']
    ]);
    $_SESSION['message'] = "Training Data Successfully Saved!";
    header("Location: index.php"); 
    exit();
}
?>